<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrivateMessageController extends AbstractController
{
    #[Route('/private/message', name: 'app_private_message')]
    public function index(): Response
    {
        return $this->render('private_message/index.html.twig', [
            'controller_name' => 'PrivateMessageController',
        ]);
    }
}
