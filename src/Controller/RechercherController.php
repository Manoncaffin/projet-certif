<?php

namespace App\Controller;

use App\Entity\Announce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ResearchFormType;
use App\Repository\AnnounceRepository;
use App\Repository\ClassificationMaterialRepository;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RechercherController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/rechercher', name: 'app_rechercher')]
    public function search(Request $request, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {
        $researchForm = $this->createForm(ResearchFormType::class);
        $researchForm->handleRequest($request);

        $materials = $materialRepository->findAll();
        $announces = [];
        $selectedMaterial = null;

        // $announcesJson = '';
        
        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            $selectedMaterial = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');
            $selectedMaterial = $materialRepository->findOneBy(['material' => $selectedMaterial]);
            $geographicalArea = $researchForm->get('geographicalArea')->getData();
            $announces = $announceRepository->findByClassificationAndMaterialAndGeographicalArea($selectedMaterial, $geographicalArea);
        }
            return $this->render('rechercher/index.html.twig', [
            'controller_name' => 'RechercherController',
            'researchForm' => $researchForm->createView(),
            'materials' => $materials,
            'selectedMaterial' => $selectedMaterial,
            'announces' => $announces,
        ]);
    }

    
            // $announcesJson = json_encode($announces);
            // $materialAnnounce = $request->request->all()['material-bio-select'];
            // if (!$materialAnnounce) {
            //     $materialAnnounce = $request->request->all()['material-geo-select'];
            // }

            // $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);
            // // dd($selectedMaterial);
            // $geographicalArea = $researchForm->get('geographicalArea')->getData();

            // $announces = $announceRepository->findByClassificationAndMaterialAndGeographicalArea($selectedMaterial, $geographicalArea);

            // $announcesJson = json_encode($announces);
            // dump($announces);
        // }

    // CRÉER NOUVELLE ROUTE POUR AFFICHER LES ANNONCES DANS LA MAP
    #[Route('/rechercher/{id}/{material}/{geographicalArea}', name: 'app_rechercher_show')]
    public function show(Request $request, AnnounceRepository $announceRepository, MaterialRepository $materialRepository, ClassificationMaterialRepository $classificationMaterialRepository, $id, $material, $geographicalArea): Response
    {
        $selectedClassification = $classificationMaterialRepository->findOneById($id);
        $selectedMaterial = $materialRepository->findOneBy(['material' => $material]);

        $announces = $announceRepository->findByClassificationMaterialAndMaterialAndGeographicalArea($selectedClassification, $selectedMaterial, $geographicalArea);

        return $this->render('rechercher/show.html.twig', [
            'controller_name' => 'RechercherController',
            'announces' => $announces,
            'selectedClassification' => $selectedClassification,
            'selectedMaterial' => $selectedMaterial,
            'geographicalArea' => $geographicalArea,
        ]);
    }
}
