<?php

namespace App\Controller;

use App\Form\ResearchFormType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use App\Service\MaterialSearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RechercherController extends AbstractController
{

    private $entityManager;
    private $materialSearchService;

    public function __construct(EntityManagerInterface $entityManager, MaterialSearchService $materialSearchService)
    {
        $this->entityManager = $entityManager;
        $this->materialSearchService = $materialSearchService;
    }

    #[Route('/rechercher', name: 'app_rechercher')]
    public function search(Request $request): Response
    {

        $researchForm = $this->createForm(ResearchFormType::class);
        $researchForm->handleRequest($request);

        $materials = $this->materialSearchService->findAllMaterials();
        $announces = [];
        $selectedMaterial = null;

        if ($researchForm->isSubmitted() && $researchForm->isValid()) {
            $selectedMaterial = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');
            $selectedMaterials = $this->materialSearchService->findMaterialByPartialName($selectedMaterial);
            
            if (count($selectedMaterials) === 1) {
                $selectedMaterial = $selectedMaterials[0];
            } else {
                $this->addFlash('error', 'Plusieurs matériaux correspondent à votre sélection. Veuillez être plus précis.');
                return $this->redirectToRoute('app_rechercher');
            }

            $geographicalArea = $researchForm->get('geographicalArea')->getData();

            return $this->redirectToRoute('app_rechercher_show', [
                'material' => $selectedMaterial->getMaterial(),
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

    #[Route('/rechercher/{material}/{geographicalArea}', name: 'app_rechercher_show')]
    public function show(Request $request, $material, $geographicalArea, AnnounceRepository $announceRepository, MaterialRepository $materialRepository, SerializerInterface $serializer): Response
    {

        $currentUser = $this->getUser();
        $researchForm = $this->createForm(ResearchFormType::class);
        $researchForm->handleRequest($request);
        
        $selectedMaterial = $materialRepository->findOneBy(['material' => $material]);

        if ($currentUser) {
            $announces = $announceRepository->findByClassificationMaterialAndMaterialAndGeographicalArea($selectedMaterial, $geographicalArea, $currentUser);
        } else {
            $announces = $announceRepository->findByClassificationMaterialAndMaterialAndGeographicalAreaExcludeUser($selectedMaterial, $geographicalArea);
        }

        if (!empty($announces)) {
            $json = [
                "material" => $announces[0]->getMaterial()->getMaterial(),
                "geographicalArea" => $announces[0]->getGeographicalArea(),
                "description" => $announces[0]->getDescription(),
                "createdAt" => $announces[0]->getCreatedAt(),
                "id" => $announces[0]->getId(),
                'type' => $announces[0]->getType() ?? 'N/A', 
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