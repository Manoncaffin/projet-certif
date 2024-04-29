<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SectorActivityController extends AbstractController
{
    #[Route('/sector/activity', name: 'app_sector_activity')]
    public function index(): Response
    {
        return $this->render('sector_activity/index.html.twig', [
            'controller_name' => 'SectorActivityController',
        ]);
    }
}
