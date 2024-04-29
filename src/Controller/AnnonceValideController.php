<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceValideController extends AbstractController
{
    #[Route('/annonce/valide', name: 'app_annonce_valide')]
    public function index(): Response
    {
        return $this->render('annonce_valide/index.html.twig', [
            'controller_name' => 'AnnonceValideController',
        ]);
    }
}
