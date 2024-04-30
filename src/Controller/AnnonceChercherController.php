<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceChercherController extends AbstractController
{
    #[Route('/annonce-chercher', name: 'app_annonce_chercher')]
    public function index(): Response
    {
        return $this->render('annonce-chercher/index.html.twig', [
            'controller_name' => 'AnnonceChercherController',
        ]);
    }
}
