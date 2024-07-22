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

class AnnonceDonnerController extends AbstractController
{
    private $entityManager;
    private $materialSearchService;

    public function __construct(EntityManagerInterface $entityManager, MaterialSearchService $materialSearchService)
    {
        $this->entityManager = $entityManager;
        $this->materialSearchService = $materialSearchService;
    }

    #[Route('/annonce-donner', name: 'app_annonce_donner')]
    public function index(MaterialRepository $materialRepository, VolumeRepository $volumeRepository, Request $request, SluggerInterface $slugger): Response
    {
        $materials = $this->materialSearchService->findAllMaterials();
        $user = $this->getUser();

        $announce = new Announce();
        $giveForm = $this->createForm(GiveType::class, $announce);
        $giveForm->handleRequest($request);

        if ($giveForm->isSubmitted() && $giveForm->isValid()) {
            $data = $giveForm->getData();

            // Obtenir la valeur du matériau sélectionné
            $materialAnnounce = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');

            if ($materialAnnounce) {
                $selectedMaterials = $this->materialSearchService->findMaterialByPartialName($materialAnnounce);

                if (count($selectedMaterials) === 1) {
                    $selectedMaterial = $selectedMaterials[0];
                } else {
                    $this->addFlash('error', 'Plusieurs matériaux correspondent à votre sélection. Veuillez être plus précis.');
                    return $this->redirectToRoute('app_annonce_donner');
                }

                // Obtenir la valeur du volume sélectionné
                $volumeId = $data->getVolume()->getId();
                $volumes = $volumeRepository->findOneBy(['id' => $volumeId]);

                $photoFile = $giveForm->get('photo')->getData();
                if ($photoFile) {
                    $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                    try {
                        $photoFile->move($this->getParameter('photo_directory'), $newFilename);
                        $photoAnnounce = new File();
                        $photoAnnounce->setUrl($newFilename);
                        $photoAnnounce->setAnnounce($announce);
                        $announce->addPhoto($photoAnnounce);
                        $this->entityManager->persist($photoAnnounce);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Il y a un problème avec votre fichier.');
                    }
                }

                $announce->setUser($user);
                $announce->setMaterial($selectedMaterial);
                $announce->setVolume($volumes);
                $announce->setType('donner');

                $this->entityManager->persist($announce);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre annonce a été ajoutée avec succès.');
                return $this->redirectToRoute('app_annonce_valide');
            } else {
                $this->addFlash('error', 'Veuillez sélectionner un matériau.');
            }
        } else {
            $this->addFlash('error', 'Le formulaire n\'est pas valide.');
        }

        return $this->render('annonce_donner/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'materials' => $materials,
        ]);
    }
}