<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\CodeSpace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(CodeSpace::class);

        $token = null;
        do {
            $token = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 3);
            $existing = $repository->findOneBy(['link' => $token]);
        } while ($existing); 

        $entity = new CodeSpace();
        $entity->setLink($token);
        $entity->setDateCreate(new \DateTime('now'));      
        $entity->setDateExpire(new \DateTime('tomorrow')); 
        $entity->setIsRegister(false);                    
        $entity->setIsUpdate(false);
        $entity->setIsFinish(false);
        $entity->setHasStarted(false);
        $entity->setWriterId(null);

        $em->persist($entity);
        $em->flush();
         
        return $this->redirectToRoute('app_codespace', ['token' => $token]);
    }

    #[Route('/{token}', name: 'app_codespace', methods: ['GET', 'POST'])]
    public function codespace(EntityManagerInterface $em, string $token, Request $request): Response
    {
        $repository = $em->getRepository(CodeSpace::class);
        $codeSpace = $repository->findOneBy(['link' => $token]);

        if (!$codeSpace) {
            return $this->redirectToRoute('app_home');
        }

        if ($request->isMethod('POST')) {
            if ($codeSpace->isFinish()) {
                return $this->json([
                    'status' => 'error',
                    'message' => 'Ce CodeSpace est verrouillé.'
                ], 403);
            }

            $data = json_decode($request->getContent(), true);
            $clientId = $data['clientId'] ?? null;

            if (!$clientId) {
                return $this->json([
                    'status' => 'error',
                    'message' => 'Client ID manquant.'
                ], 400);
            }

            if (isset($data['champ'])) {
                // Si personne n'a encore écrit, le premier devient le writer
                if (!$codeSpace->getWriterId()) {
                    $codeSpace->setWriterId($clientId);
                    $codeSpace->setHasStarted(true);
                }

                // Seul le writer peut modifier le contenu
                if ($codeSpace->getWriterId() === $clientId) {
                    $codeSpace->setTxtInput($data['champ']);
                    $codeSpace->setIsUpdate(true);
                } else {
                    return $this->json([
                        'status' => 'error',
                        'message' => 'Vous êtes en mode lecture seule.'
                    ], 403);
                }
            }

            if (isset($data['isFinished']) && $data['isFinished'] === true) {
                if ($codeSpace->getWriterId() === $clientId) {
                    $codeSpace->setIsFinish(true);
                }
            }

            $em->flush();

            return $this->json(['status' => 'ok']);
        }

        return $this->render('home_page/index.html.twig', [
            'codeSpace' => $codeSpace,
            'token' => $token,
        ]);
    }

    #[Route('/{token}/claim-writer', name: 'app_claim_writer', methods: ['POST'])]
    public function claimWriter(EntityManagerInterface $em, string $token, Request $request): JsonResponse
    {
        $repository = $em->getRepository(CodeSpace::class);
        $codeSpace = $repository->findOneBy(['link' => $token]);

        if (!$codeSpace) {
            return $this->json(['status' => 'error'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $clientId = $data['clientId'] ?? null;

        if (!$clientId) {
            return $this->json([
                'status' => 'error',
                'message' => 'Client ID manquant.'
            ], 400);
        }

        // Si personne n'est encore writer, on devient writer
        if (!$codeSpace->getWriterId()) {
            $codeSpace->setWriterId($clientId);
            $em->flush();
            
            return $this->json([
                'status' => 'ok',
                'isWriter' => true,
                'writerId' => $clientId
            ]);
        }

        // Sinon, on est reader
        return $this->json([
            'status' => 'ok',
            'isWriter' => false,
            'writerId' => $codeSpace->getWriterId()
        ]);
    }

    #[Route('/{token}/poll', name: 'app_codespace_poll', methods: ['GET'])]
    public function poll(EntityManagerInterface $em, string $token, Request $request): JsonResponse
    {
        $repository = $em->getRepository(CodeSpace::class);
        $codeSpace = $repository->findOneBy(['link' => $token]);

        if (!$codeSpace) {
            return $this->json(['status' => 'error'], 404);
        }

        $clientId = $request->query->get('clientId');

        return $this->json([
            'status' => 'ok',
            'content' => $codeSpace->getTxtInput() ?? '',
            'isFinished' => $codeSpace->isFinish(),
            'hasStarted' => $codeSpace->isHasStarted(),
            'writerId' => $codeSpace->getWriterId(),
            'isWriter' => $codeSpace->getWriterId() === $clientId,
        ]);
    }
}