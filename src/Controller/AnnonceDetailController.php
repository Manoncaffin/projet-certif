<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\User;
use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDetailController extends AbstractController
{

    #[Route('/annonce-detail/{id}', name: 'app_annonce_detail')]
        public function index(AnnounceRepository $announceRepository, int $id): Response
    {
        // Récupérer l'annonce à partir de la base de données
        $announce = $announceRepository->find($id);

        if (!$announce) {
            throw $this->createNotFoundException(
                'No annonce found for id '.$id
            );
        }

        $user = $this->getUser();
        $userAnnounces = $announceRepository->findByUser($user);

        return $this->render('annonce_detail/index.html.twig', [
            'user' => $user,
            'announce' => $announce,
        ]);
    }
}
