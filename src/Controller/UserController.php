<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\File;
use App\Entity\Announce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}/delete', name: 'app_user_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, Security $security): Response
    {

        $currentUser = $this->getUser();

        if ($currentUser !== $user) {
            throw $this->createAccessDeniedException('You cannot delete this account.');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $tokenStorage = $this->container->get('security.token_storage');
            $tokenStorage->setToken(null);
            $request->getSession()->invalidate();

            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été supprimé avec succès.');

            return $this->redirectToRoute('app_accueil');
        }

        return $this->redirectToRoute('app_profil');
    }

    //     /**
    //      * @var User $user 
    //      */
    //     $user=$this->getUser();
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($user);
    //         $entityManager->flush();
    //         $security->logout(false);

    //         return $this->redirectToRoute('app_accueil');
    //     }
    // }
}

