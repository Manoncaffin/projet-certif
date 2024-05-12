<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AnnonceChercherModifierController extends AbstractController
{
    private $entityManager;
    private $authorizationChecker;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/annonce-chercher-modifier/{id}', name: 'app_annonce_chercher_modifier', requirements: ["id" => "\d+"])]
    public function edit(Request $request, Announce $announce): Response
    {
        // Vérifier que l'utilisateur connecté est bien l'auteur de l'annonce
        if ($this->getUser() !== $announce->getUser()) {
            throw $this->createAccessDeniedException();
        }
        // Vérifier que l'utilisateur connecté a les autorisations nécessaires pour modifier l'annonce
        // if (!$this->authorizationChecker->isGranted('EDIT', $announce)) {
        //     throw $this->createAccessDeniedException();
        // }

        // Vérifier que l'annonce a bien été validée
        // if ($announce->getStatus() !== 'validée') {
        //     throw $this->createAccessDeniedException();
        // }

        // Vérifier que l'annonce est bien une annonce de recherche
        if ($announce->getType() !== 'chercher') {
            throw $this->createNotFoundException();
        }

        // Créez le formulaire à partir de l'entité Announce
        $form = $this->createForm(SearchType::class, $announce);
        // Traitez la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications en base de données
            $this->entityManager->flush();

            // Redirigez vers la page de détail de l'annonce
            return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
        }

        // Affichez le formulaire de modification
        return $this->render('annonce_chercher_modifier/index.html.twig', [
            'searchForm' => $form->createView(),
            'announce' => $announce,
        ]);
    }
}
