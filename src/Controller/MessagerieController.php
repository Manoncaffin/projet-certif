<?php

namespace App\Controller;

use App\Entity\Announce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessagerieController extends AbstractController
{
    #[Route('/messagerie', name: 'app_messagerie')]
    public function index(): Response
    {
        return $this->render('messagerie/index.html.twig', [
            'controller_name' => 'MessagerieController',
        ]);
    }

    #[Route('/messagerie/{id}', name: 'app_messagerie_show')]
    public function messagerie(Announce $announce): Response
    {
        return $this->render('messagerie/show.html.twig', [
            'controller_name' => 'MessagerieController',
            'announce' => $announce,
        ]);
    }
}
