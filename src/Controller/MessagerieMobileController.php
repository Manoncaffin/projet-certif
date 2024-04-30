<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessagerieMobileController extends AbstractController
{
    #[Route('/messagerie-mobile', name: 'app_messagerie_mobile')]
    public function index(): Response
    {
        return $this->render('messagerie_mobile/index.html.twig', [
            'controller_name' => 'MessagerieMobileController',
        ]);
    }
}
