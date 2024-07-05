<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\SearchType;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AnnonceChercherModifierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce-chercher-modifier/{id}', name: 'app_annonce_chercher_modifier', requirements: ["id" => "\d+"])]
    public function edit(Request $request, Announce $announce, MaterialRepository $materialRepository): Response
    {
        // Vérifier que l'utilisateur connecté est bien l'auteur de l'annonce
        if ($this->getUser() !== $announce->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Vérifier que l'annonce est bien une annonce de recherche
        if ($announce->getType() !== 'chercher') {
            throw $this->createNotFoundException();
        }

        // Créez le formulaire à partir de l'entité Announce
        $searchForm = $this->createForm(SearchType::class, $announce);
        $materials = $materialRepository->findAll();

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Enregistrez les modifications en base de données
            $materialModif = $request->request->all()['material-bio-select'];
            if (!$materialModif) {
                $materialModif = $request->request->all()['material-geo-select'];
            }

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialModif]);
            $announce->setMaterial($selectedMaterial);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
        }

        // Affichez le formulaire de modification
        return $this->render('annonce_chercher_modifier/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'announce' => $announce,
            'materials' => $materials,
        ]);
    }
}
