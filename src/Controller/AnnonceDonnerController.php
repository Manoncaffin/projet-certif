<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDonnerController extends AbstractController
{
    #[Route('/annonce/donner', name: 'app_annonce_donner')]
    public function index(): Response
    {
        return $this->render('annonce_donner/index.html.twig', [
            'controller_name' => 'AnnonceDonnerController',
        ]);
    }
}
