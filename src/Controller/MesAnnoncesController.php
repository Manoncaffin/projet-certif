<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AnnounceRepository;

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
}
