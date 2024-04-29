<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MesAnnoncesController extends AbstractController
{
    #[Route('/mes/annonces', name: 'app_mes_annonces')]
    public function index(): Response
    {
        return $this->render('mes_annonces/index.html.twig', [
            'controller_name' => 'MesAnnoncesController',
        ]);
    }
}
