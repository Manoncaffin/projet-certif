<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModificationsInformationsController extends AbstractController
{
    #[Route('/modifications/informations', name: 'app_modifications_informations')]
    public function index(): Response
    {
        return $this->render('modifications_informations/index.html.twig', [
            'controller_name' => 'ModificationsInformationsController',
        ]);
    }
}
