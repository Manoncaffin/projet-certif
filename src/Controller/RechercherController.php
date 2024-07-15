<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\ResearchFormType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;

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

        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            $selectedMaterial = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');
            $selectedMaterial = $materialRepository->findOneBy(['material' => $selectedMaterial]);
            $geographicalArea = $researchForm->get('geographicalArea')->getData();

            return $this->redirectToRoute('app_rechercher_show', [
                'material' => $selectedMaterial,
                'geographicalArea' => $geographicalArea,
                'announces' => $announces
            ]);
        }


        return $this->render('rechercher/index.html.twig', [
            'controller_name' => 'RechercherController',
            'researchForm' => $researchForm->createView(),
            'materials' => $materials,
            'selectedMaterial' => $selectedMaterial,
            'announces' => $announces,
        ]);
    }


    // CRÉER NOUVELLE ROUTE POUR AFFICHER LES ANNONCES DANS LA MAP
    #[Route('/rechercher/{material}/{geographicalArea}', name: 'app_rechercher_show')]
    public function show(Request $request, $material, $geographicalArea, AnnounceRepository $announceRepository, MaterialRepository $materialRepository, SerializerInterface $serializer): Response
    {

        $researchForm = $this->createForm(ResearchFormType::class);
        $researchForm->handleRequest($request);
        
        $selectedMaterial = $materialRepository->findOneBy(['material' => $material]);

        $announces = $announceRepository->findByClassificationMaterialAndMaterialAndGeographicalArea($selectedMaterial, $geographicalArea);

        if (!empty($announces)) {
            $json = [
                "material" => $announces[0]->getMaterial()->getMaterial(),
                "geographicalArea" => $announces[0]->getGeographicalArea(),
                "description" => $announces[0]->getDescription(),
                "createdAt" => $announces[0]->getCreatedAt(),
                "id" => $announces[0]->getId(),
            ];

            $jsonData = $serializer->serialize($json, 'json');

            return $this->render('rechercher/show.html.twig', [
                'controller_name' => 'RechercherController',
                'announces' => $announces,
                'Json' => $jsonData,
            ]);
        }
        
        return $this->render('rechercher/show.html.twig', [
            'controller_name' => 'RechercherController',
            'announces' => [],
            'Json' => '[]',
        ]);
    }
}