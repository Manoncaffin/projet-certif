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
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker, Security $security): Response
    {

        /**
         * @var User $user 
         */
        $user=$this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $security->logout(false);

            return $this->redirectToRoute('app_accueil');
        }
        

         // Vérifier que l'utilisateur connecté est autorisé à supprimer l'utilisateur courant
        //  if (!$authorizationChecker->isGranted('DELETE', $user)) {
        //     $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer ce compte.');
        //     return $this->redirectToRoute('app_accueil');
        // }

        // if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
        //     // Supprimer les fichiers associés aux annonces de l'utilisateur
        //     $files = $entityManager->createQueryBuilder()
        //         ->delete('f')
        //         ->from(File::class, 'f')
        //         ->innerJoin(Announce::class, 'a', 'WITH', 'f.announce = a.id')
        //         ->innerJoin(User::class, 'u', 'WITH', 'a.user = u.id')
        //         ->where('u.id = :userId')
        //         ->setParameter('userId', $user->getId())
        //         ->getQuery()
        //         ->getResult();

        //     foreach ($files as $file) {
        //         $entityManager->remove($file);
        //     }

        //     // Supprimer les annonces de l'utilisateur
        //     $announces = $user->getAnnounces();

        //     foreach ($announces as $announce) {
        //         $entityManager->remove($announce);
        //     }

        //     // Supprimer l'utilisateur
        //     $entityManager->remove($user);
        //     $entityManager->flush();

        //     $this->addFlash('success', 'Votre compte a été supprimé avec succès.');
        // } else {
        //     $this->addFlash('error', 'Erreur lors de la suppression du compte.');
        // }

        // return $this->redirectToRoute('app_accueil');
    }
}
