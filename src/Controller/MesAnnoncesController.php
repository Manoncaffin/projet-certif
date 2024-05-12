<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnounceRepository;
use App\Entity\File;
use App\Entity\Announce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface as TokenGeneratorTokenGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGeneratorInterface;

class MesAnnoncesController extends AbstractController
{
    #[Route('/mes-annonces', name: 'app_mes_annonces')]
    public function mesAnnonces(AnnounceRepository $announceRepository): Response
    {
        $user = $this->getUser();
        $userAnnounces = $announceRepository->findBy(['user' => $user]);

        return $this->render('mes_annonces/index.html.twig', [
            'controller_name' => 'MesAnnoncesController',
            'user' => $this->getUser(),
            'userAnnounces' => $userAnnounces,
        ]);
    }

    #[Route("/{id}", name:"announce_delete", methods: ["DELETE"])]
    public function delete(Announce $announce, Request $request, EntityManagerInterface $entityManager, TokenGeneratorTokenGeneratorInterface $tokenGenerator): Response
    {
        $csrfToken = $tokenGenerator->generateToken('delete' . $announce->getId());
        $token = $request->request->get('_token');

        if (!$this->isCsrfTokenValid('delete' . $announce->getId(), $token)) {
            throw new \Exception('Invalid CSRF token.');
        }

        // Vérifier le type de l'annonce avant de supprimer les fichiers liés
        if ($announce->getType() === 'donner') {
        // Supprimer les fichiers liés à l'annonce
        foreach ($announce->getPhoto() as $file) {
            $entityManager->remove($file);
        }
    }

        $entityManager->remove($announce);
        $entityManager->flush();

        return $this->redirectToRoute('app_mes_annonces');
    }

}
