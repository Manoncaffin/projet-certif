<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceChercherController extends AbstractController
{
    #[Route('/annonce_chercher', name: 'app_annonce_chercher')]
    public function index(MaterialRepository $materialRepository): Response
    {
        $materials = $materialRepository->findAll();

        $searchForm = $this->createForm(SearchType::class);

        return $this->render('annonce_chercher/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'materials' => $materials
        ]);
        // return $this->render('annonce_chercher/index.html.twig', [
        //     'controller_name' => 'AnnonceChercherController',
        // ]);
    }
}
