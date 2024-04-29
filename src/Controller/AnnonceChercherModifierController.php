<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceChercherModifierController extends AbstractController
{
    #[Route('/annonce/chercher/modifier', name: 'app_annonce_chercher_modifier')]
    public function index(): Response
    {
        return $this->render('annonce_chercher_modifier/index.html.twig', [
            'controller_name' => 'AnnonceChercherModifierController',
        ]);
    }
}
