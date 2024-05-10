<?php

namespace App\Controller;

use App\Entity\Volume;
use App\Repository\VolumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VolumeController extends AbstractController
{
    #[Route('/volume', name: 'app_volume')]
    public function select(VolumeRepository $volumeRepository): Response
    {
        $volumes = $volumeRepository->findAll();

        return $this->render('volume/index.html.twig', [
            'volumes' => $volumes,
        ]);
    }
}
