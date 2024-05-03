<?php

namespace App\Controller;

use App\Form\GiveType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDonnerController extends AbstractController
{
    #[Route('/annonce-donner', name: 'app_annonce_donner')]
    public function index(MaterialRepository $materialRepository): Response
    {
        $materials = $materialRepository->findAll();

        // CREATION DE LA VARIABE GIVEFORM POUR L'UTILISATEUR DANS LA VUE TWIG
        $giveForm = $this->createForm(GiveType::class);

        return $this->render('annonce_donner/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'materials' => $materials
        ]);

        // return $this->render('annonce_donner/index.html.twig', [
        //     'controller_name' => 'AnnonceDonnerController',
        // ]);
    }
}
