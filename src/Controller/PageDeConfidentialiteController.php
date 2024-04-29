<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageDeConfidentialiteController extends AbstractController
{
    #[Route('/page/de/confidentialite', name: 'app_page_de_confidentialite')]
    public function index(): Response
    {
        return $this->render('page_de_confidentialite/index.html.twig', [
            'controller_name' => 'PageDeConfidentialiteController',
        ]);
    }
}
