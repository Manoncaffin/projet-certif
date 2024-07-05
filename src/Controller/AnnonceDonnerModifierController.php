<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Material;
use App\Form\GiveType;
use App\Repository\MaterialRepository;
use App\Repository\VolumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceDonnerModifierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce-donner-modifier/{id}", name: "app_annonce_donner_modifier', requirements: ["id" => "\d+"])]
    public function edit(Request $request, Announce $announce, MaterialRepository $materialRepository, VolumeRepository $volumeRepository): Response
    {
        // Créez le formulaire à partir de l'entité Announce
        $giveForm = $this->createForm(GiveType::class, $announce);
        $materials = $materialRepository->findAll();

        // Traitez la soumission du formulaire
        $giveForm->handleRequest($request);
        if ($giveForm->isSubmitted() && $giveForm->isValid()) {

            $materialModif = $request->request->all()['material-bio-select'];
            if(!$materialModif) {
                $materialModif = $request->request->all()['material-geo-select'];
            }

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialModif]);
            $announce -> setMaterial($selectedMaterial);
            
            // Enregistrez les modifications en base de données
            $this->entityManager->flush();

            // Redirigez vers la page de confirmation
            // return $this->redirectToRoute('app_annonce_valide');
            // Redirigez vers la page de détail de l'annonce
            return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
        }

        // Affichez le formulaire de modification
        return $this->render('annonce_donner_modifier/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'announce' => $announce,
            'materials' => $materials
        ]);
    }
}
