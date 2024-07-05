<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Material;
use App\Form\GiveType;
use App\Repository\MaterialRepository;
use App\Repository\VolumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function edit(Request $request, Announce $announce, MaterialRepository $materialRepository, VolumeRepository $volumeRepository, SluggerInterface $slugger): Response
    {
        // Créez le formulaire à partir de l'entité Announce
        $giveForm = $this->createForm(GiveType::class, $announce);
        $materials = $materialRepository->findAll();

        // Traitez la soumission du formulaire
        $giveForm->handleRequest($request);
        if ($giveForm->isSubmitted() && $giveForm->isValid()) {

            // // Gérez la photo
            // $photoFile = $giveForm->get('photo')->getData();
            // if ($photoFile) {
            //     $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

            //     // Déplacez le fichier vers le répertoire où les photos sont stockées
            //     try {
            //         $photoFile->move($this->getParameter('photo_directory'), $newFilename);
            //         $announce->setPhotoFile($newFilename); // Mettez à jour l'URL de la photo dans l'entité Announce
            //     } catch (FileException $e) {
            //         // Gérez l'exception si quelque chose se passe mal lors du téléchargement du fichier
            //         $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la photo.');
            //     }
            // }

            $materialModif = $request->request->all()['material-bio-select'];
            if (!$materialModif) {
                $materialModif = $request->request->all()['material-geo-select'];
            }

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialModif]);
            $announce->setMaterial($selectedMaterial);

            // Enregistrez les modifications en base de données
            $this->entityManager->flush();

            return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
        }

        // Affichez le formulaire de modification
        return $this->render('annonce_donner_modifier/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'announce' => $announce,
            'materials' => $materials,
        ]);
    }
}
