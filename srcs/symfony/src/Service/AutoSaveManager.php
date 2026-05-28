<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use App\Service\RedisDataManager; // Décommenté pour assurer la liaison

class AutoSaveManager
{
    // C'est grâce à $autosaveLimiter que Symfony fait le lien tout seul avec autosave_limiter du YAML !
    public function __construct(
        private RedisDataManager $redisManager,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private RateLimiterFactory $autosaveLimiter
    ) {
    }

    public function processAutoSave(Request $request, string $token): JsonResponse
    {
        try {
            // --- 1. LECTURE INITIALE REDIS ---
            $currentCache = $this->redisManager->readData($token);

            if (!$currentCache) {
                return new JsonResponse(['message' => 'Room introuvable.'], Response::HTTP_NOT_FOUND);
            }

            if (isset($currentCache['is_editable']) && $currentCache['is_editable'] === false) {
                return new JsonResponse(['message' => 'Ce document est verrouillé.', 'is_editable' => false], Response::HTTP_FORBIDDEN);
            }

            if (isset($currentCache['creator_ip']) && $currentCache['creator_ip'] !== $request->getClientIp()) {
                return new JsonResponse(['message' => 'Vous n\'êtes pas le propriétaire.'], Response::HTTP_FORBIDDEN);
            }

            // --- 2. RATE LIMITER ---
            $limiter = $this->autosaveLimiter->create($request->getClientIp());
            if (false === $limiter->consume(1)->isAccepted()) {
                return new JsonResponse(['message' => 'Trop de requêtes. Veuillez patienter.'], Response::HTTP_TOO_MANY_REQUESTS);
            }

            // --- 3. DÉCODAGE JSON ---
            $data = json_decode($request->getContent(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return new JsonResponse(['message' => 'JSON invalide.'], Response::HTTP_BAD_REQUEST);
            }

            $content = $data['content'] ?? null;
            $submittedToken = $request->headers->get('X-CSRF-TOKEN');
            $forceLock = $data['force_lock'] ?? false; 

            if ($content === null || !$submittedToken) {
                return new JsonResponse(['message' => 'Données manquantes (content ou header X-CSRF-TOKEN).'], Response::HTTP_BAD_REQUEST);
            }

            // --- EXTRA SÉCURITÉ : ANTI-SCRIPT MALVEILLANT (XSS) ---
            $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

            // --- 4. VÉRIFICATION CSRF ---
            $csrfTokenObj = new CsrfToken('room_action_' . $token, $submittedToken);
            if (!$this->csrfTokenManager->isTokenValid($csrfTokenObj)) {
                return new JsonResponse(['message' => 'Token CSRF invalide.'], Response::HTTP_FORBIDDEN);
            }

            // --- 5. VÉRIFICATION TAILLE ---
            if (mb_strlen($content) > 50000) { 
                return new JsonResponse(['message' => 'Contenu trop volumineux.'], Response::HTTP_BAD_REQUEST);
            }

            // --- 6. ÉCRITURE DANS REDIS ---
            $nextEditableState = $forceLock ? false : true;
            $this->redisManager->writeData($token, $content, $request->getClientIp(), $nextEditableState);

            // --- 7. RÉPONSE DE SUCCÈS ---
            return new JsonResponse([
                'status' => 'success',
                'message' => 'Mis à jour avec succès.',
                'is_editable' => $nextEditableState
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Erreur Interne du Serveur (500)',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}