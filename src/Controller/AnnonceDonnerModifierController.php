<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDonnerModifierController extends AbstractController
{
    #[Route('/annonce/donner/modifier', name: 'app_annonce_donner_modifier')]
    public function index(): Response
    {
        return $this->render('annonce_donner_modifier/index.html.twig', [
            'controller_name' => 'AnnonceDonnerModifierController',
        ]);
    }
}
