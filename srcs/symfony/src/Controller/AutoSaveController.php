<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;



final class AutoSaveController extends AbstractController
{
   
   #[Route('/{token}/update', name: 'app_room_update', methods: ['POST'])]
    public function updateRoom(
        string $token,
        Request $request, 
        RedisDataManager $redisManager, 
        RateLimiterFactory $autosaveLimiter,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {
    try {
        // --- LECTURE INITIALE REDIS ---
        $currentCache = $redisManager->readData($token);
      

        if (!$currentCache) {
            return new JsonResponse(['message' => 'Room introuvable.'], Response::HTTP_NOT_FOUND);
        }

        if (isset($currentCache['is_editable']) && $currentCache['is_editable'] === false) {
            return new JsonResponse(['message' => 'Ce document est verrouillé.', 'is_editable' => false], Response::HTTP_FORBIDDEN);
        }

        if (isset($currentCache['creator_ip']) && $currentCache['creator_ip'] !== $request->getClientIp()) {
            return new JsonResponse(['message' => 'Vous n\'êtes pas le propriétaire.'], Response::HTTP_FORBIDDEN);
        }

        // --- RATE LIMITER ---
        $limiter = $autosaveLimiter->create($request->getClientIp());
        if (false === $limiter->consume(1)->isAccepted()) {
            return new JsonResponse(['message' => 'Trop de requêtes.'], Response::HTTP_TOO_MANY_REQUESTS);
        }

        // --- DÉCODAGE JSON ---
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['message' => 'JSON invalide.'], Response::HTTP_BAD_REQUEST);
        }

        $text = $data['text'] ?? null;
        $submittedToken = $data['csrf_token'] ?? null;
        $forceLock = $data['force_lock'] ?? false; 

        if ($text === null || !$submittedToken) {
            return new JsonResponse(['message' => 'Données manquantes (text ou csrf_token).'], Response::HTTP_BAD_REQUEST);
        }

        // --- VÉRIFICATION CSRF ---
        $csrfTokenObj = new CsrfToken('room_action_' . $token, $submittedToken);
        if (!$csrfTokenManager->isTokenValid($csrfTokenObj)) {
            return new JsonResponse(['message' => 'Token CSRF invalide.'], Response::HTTP_FORBIDDEN);
        }

        if (mb_strlen($text) > 50000) { 
            return new JsonResponse(['message' => 'Contenu trop volumineux.'], Response::HTTP_BAD_REQUEST);
        }

        // --- ÉCRITURE ---
        $nextEditableState = $forceLock ? false : true;
        $redisManager->writeData($token, $text, $request->getClientIp(), $nextEditableState);

        return new JsonResponse([
            'message' => 'Mis à jour avec succès.',
            'is_editable' => $nextEditableState
        ], Response::HTTP_OK);

    } catch (\Exception $e) {
        // En cas d'erreur 500, on attrape l'erreur et on affiche le vrai message dans la console
        return new JsonResponse([
            'message' => 'Erreur Interne du Serveur (500)',
            'debug' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    
}