<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Material;
use App\Form\SearchType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use App\Service\MaterialSearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AnnonceChercherModifierController extends AbstractController
{
    private $entityManager;
    private $materialSearchService;

    public function __construct(EntityManagerInterface $entityManager, MaterialSearchService $materialSearchService, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->materialSearchService = $materialSearchService;
    }

    #[Route('/annonce-chercher-modifier/{id}', name: 'app_annonce_chercher_modifier', requirements: ["id" => "\d+"])]
    public function edit($id, Request $request, Announce $announce, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {
        $user = $this->getUser();

        if ($user !== $announce->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($announce->getType() !== 'chercher') {
            throw $this->createNotFoundException();
        }

        $searchForm = $this->createForm(SearchType::class, $announce);
        $materials = $materialRepository->findAll();
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $materialModif = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');

            if ($materialModif) {
                $selectedMaterials = $this->materialSearchService->findMaterialByPartialName($materialModif);

                if (count($selectedMaterials) === 1) {
                    $selectedMaterial = $selectedMaterials[0];
                    $announce->setMaterial($selectedMaterial);
                    $this->entityManager->flush();

                    return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
                } else {
                    $this->addFlash('error', 'Plusieurs matériaux correspondent à votre sélection. Veuillez être plus précis.');
                }
            } else {
                $this->addFlash('error', 'Veuillez sélectionner un matériau.');
            }
        }

        return $this->render('annonce_chercher_modifier/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'announce' => $announce,
            'materials' => $materials,
        ]);
    }
}
