<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceChercherControllerAnnonceChercherController extends AbstractController
{
    #[Route('/annonce/chercher/controller/annonce/chercher', name: 'app_annonce_chercher_controller_annonce_chercher')]
    public function index(): Response
    {
        return $this->render('annonce_chercher_controller_annonce_chercher/index.html.twig', [
            'controller_name' => 'AnnonceChercherControllerAnnonceChercherController',
        ]);
    }
}
