<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\File;
use App\Entity\Material;
use App\Form\GiveType;
use App\Repository\MaterialRepository;
use App\Repository\VolumeRepository;
use App\Service\MaterialSearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class AnnonceDonnerModifierController extends AbstractController
{
    private $entityManager;
    private $materialSearchService;

    public function __construct(EntityManagerInterface $entityManager, MaterialSearchService $materialSearchService)
    {
        $this->entityManager = $entityManager;
        $this->materialSearchService = $materialSearchService;
    }

    #[Route('/annonce-donner-modifier/{id}", name: "app_annonce_donner_modifier', requirements: ["id" => "\d+"])]
    public function edit(Request $request, Announce $announce, MaterialRepository $materialRepository, VolumeRepository $volumeRepository, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        if ($user !== $announce->getUser()) {
            throw $this->createAccessDeniedException();
        }
    
        if ($announce->getType() !== 'donner') {
            throw $this->createNotFoundException('Annonce non trouvée pour modification.');
        }

        $giveForm = $this->createForm(GiveType::class, $announce);
        $materials = $materialRepository->findAll();
        $giveForm->handleRequest($request);

        if ($giveForm->isSubmitted() && $giveForm->isValid()) {
            $photoFile = $giveForm->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                $photoDirectory = $this->getParameter('photo_directory');

                try {
                    foreach ($announce->getPhoto() as $existingPhoto) {
                        $filesystem = new Filesystem();
                        $filePath = $photoDirectory . '/' . $existingPhoto->getUrl();
                        if ($filesystem->exists($filePath)) {
                            $filesystem->remove($filePath);
                        }
                        $this->entityManager->remove($existingPhoto);
                    }

                    $photoFile->move($photoDirectory, $newFilename);

                    $photoAnnounce = new File();
                    $photoAnnounce->setUrl($newFilename);
                    $photoAnnounce->setAnnounce($announce);
                    $announce->addPhoto($photoAnnounce);
                    $this->entityManager->persist($photoAnnounce);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la photo.');
                }
            }

            $materialModif =  $request->request->get('material-geo-select') ?: $request->request->get('material-bio-select'); 
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

        return $this->render('annonce_donner_modifier/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'announce' => $announce,
            'materials' => $materials,
        ]);
    }
}
