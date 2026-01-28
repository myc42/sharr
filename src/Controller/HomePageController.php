<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use App\Entity\CodeSpace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;



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

         $em->persist($entity);
         $em->flush() ;
         
       return $this->redirectToRoute('app_codespace', ['token' => $token]);

    }



#[Route('/{token}', name: 'app_codespace', methods: ['GET','POST'])]
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

        if (isset($data['champ'])) {
            $codeSpace->setTxtInput($data['champ']);
        }

        if (isset($data['isFinished']) && $data['isFinished'] === true) {
            $codeSpace->setIsFinish(true);
        }

        $em->flush();

        return $this->json(['status' => 'ok']);
    }

    return $this->render('home_page/index.html.twig', [
        'codeSpace' => $codeSpace,
        'token' => $token,
        'isReadOnly' => $codeSpace->isFinish(),
    ]);
}
}