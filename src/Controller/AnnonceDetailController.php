<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDetailController extends AbstractController
{
    #[Route('/annonce/detail', name: 'app_annonce_detail')]
    public function index(): Response
    {
        return $this->render('annonce_detail/index.html.twig', [
            'controller_name' => 'AnnonceDetailController',
        ]);
    }
}
