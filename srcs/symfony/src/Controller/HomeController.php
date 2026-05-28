<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RedisDataManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken; // <-- AJOUT IMPORTANT POUR L'ÉTAPE 4
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;


final class HomeController extends AbstractController
{
    #[Route('/{token}', name: 'app_room')]
    public function room(
        Request $request, 
        string $token, 
        RedisDataManager $redisManager,
        CsrfTokenManagerInterface $csrfTokenManager,
        #[Autowire(service: 'limiter.autosave_limiter')]
        RateLimiterFactory $autosaveLimiter,
        HubInterface $hub,

    ): Response {
        
        // --- GESTION DE LA SAUVEGARDE AJAX ---
        if($request->isMethod('POST') && $request->getContentTypeFormat() === 'json') {
            try {
                // --- 1. LECTURE INITIALE REDIS ---
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

               // --- 2. RATE LIMITER (Désactivé temporairement pour le test) ---
                $limiter = $autosaveLimiter->create($request->getClientIp());
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

                // --- 4. VÉRIFICATION CSRF ---
                $csrfTokenObj = new CsrfToken('room_action_' . $token, $submittedToken);
                if (!$csrfTokenManager->isTokenValid($csrfTokenObj)) {
                    return new JsonResponse(['message' => 'Token CSRF invalide.'], Response::HTTP_FORBIDDEN);
                }

                // --- 5. VÉRIFICATION TAILLE ---
                if (mb_strlen($content) > 100000) { 
                    return $this->redirectToRoute('app_home');
                    return new JsonResponse(['message' => 'Contenu trop volumineux.'], Response::HTTP_BAD_REQUEST);
                }

                // --- 6. ÉCRITURE DANS REDIS ---
                $nextEditableState = $forceLock ? false : true;

                $redisManager->writeData($token, $content, $request->getClientIp(), $nextEditableState);

                                // --- MERCURE : publication temps réel ---
                $topic = 'http://localhost:8080/' . $token; // identique côté frontend

                $update = new Update(
                    $topic,
                    json_encode([
                        'content'     => $content,
                        'is_editable' => $nextEditableState,
                        'token'       => $token,
                    ])
                );
                 $hub->publish($update);

// --- FIN MERCURE ---
                

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
                            'debug' => $e->getMessage() // Laissé actif au cas où on aurait encore un souci
                        ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }

        // --- AFFICHAGE DE LA PAGE NORMALE ---
        $data = $redisManager->readData($token);
       
        if (!$data) {
            // 1. Initialisation Auteur
            $clientIp = $request->getClientIp();
            $content = " ";
            if (!preg_match('/^[A-Za-z0-9]{1,32}$/', $token) || strlen($token) < 3) {
                return $this->redirectToRoute('app_home');
            }
            $redisManager->writeData($token, $content, $clientIp, true);

            // On génère un token CSRF unique pour cette room
            $csrfToken = $csrfTokenManager->getToken('room_action_' . $token)->getValue();

            return $this->render('Home/author.html.twig', [
                'role' => 'writer',
                'token' => $token,
                'csrf_token' => $csrfToken,
                'item' => $content, 
            ]);
        }

        
        
        // 2. Visiteurs (Reader)
        return $this->render('Home/reader.html.twig', [
            'role' => 'reader',
            'token' => $token,
            'item' => $data['content'] ?? " ", 
            'is_editable' => $data['is_editable'] ?? false,
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $token = substr(bin2hex(random_bytes(2)), 0, 4  );
        return $this->redirectToRoute('app_room', [
            'token' => $token
        ]);
    }
}