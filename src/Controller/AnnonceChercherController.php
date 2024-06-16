<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Material;
use App\Form\SearchType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceChercherController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce-chercher', name: 'app_annonce_chercher')]
    public function index(Request $request, EntityManagerInterface $entityManager, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {

        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $materials = $materialRepository->findAll();
        $announces = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $material = $searchForm->get('material')->getData();
            $postalCode = $searchForm->get('geographicalArea')->getData();

            $announces = $announceRepository->findByMaterialAndPostalCode($material, $postalCode);

            if (empty($announces)) {
                $announce = new Announce();
                $announce->setMaterial($material);
                $announce->setGeographicalArea($postalCode);
                $announce->setUser($this->getUser());
                $announce->setType('chercher');
                $announce->setClassification($material->getClassificationMaterial());

                // $entityManager = $entityManager;
                $entityManager->persist($announce);
                $entityManager->flush();

                $this->addFlash('success', 'Votre recherche a été publiée avec succès.');

                return $this->redirectToRoute('annonce-chercher');
            } else {
                return $this->render('annonce_chercher/index.html.twig', [
                    'searchForm' => $searchForm->createView(),
                    'announces' => $announces,
                    'materials' => $materials,
                ]);
            }
        }
        
            // Retourner la réponse si le formulaire n'est pas soumis ou invalide
            return $this->render('annonce_chercher/index.html.twig', [
                'searchForm' => $searchForm->createView(),
                'materials' => $materials,
                'announces' => $announces,
            ]);
        }
    }
    //     $materials = $materialRepository->findAll();
    //     $user = $this->getUser();

    //     $announce = new Announce();
    //     $searchForm = $this->createForm(SearchType::class, $announce);
    //     $searchForm->handleRequest($request);

    //     if ($searchForm->isSubmitted() && $searchForm->isValid() && $user) { // Vérification de l'état de connexion de l'utilisateur
    //         $announce = $searchForm->getData();

    //         $materialAnnounce = $request->request->all()['material-bio-select'];

    //         $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);

    //         $announce->setUser($user);
    //         $announce->setMaterial($selectedMaterial);
    //         $announce->setType('chercher');

    //         // Vérifier si une annonce similaire existe déjà
    //         $existingAnnounce = $this->entityManager->getRepository(Announce::class)->findOneBy([
    //             'user' => $user,
    //             'material' => $selectedMaterial,
    //             'type' => 'chercher',
    //         ]);

    //         if (!$existingAnnounce) {
    //             // Si aucune annonce similaire n'existe, enregistrer la nouvelle annonce
    //             $this->entityManager->persist($announce);
    //             $this->entityManager->flush();

    //             return $this->redirectToRoute('app_annonce_valide');
    //         } else {
    //             // Afficher un message d'erreur si une annonce similaire existe déjà
    //             $this->addFlash('error', 'Vous avez déjà publié une annonce pour ce matériau.');
    //         }
    //     }

    //     // Récupérer les annonces en fonction du matériau et du code postal saisis
    //     $material = $announce->getMaterial();
    //     $postalCode = $announce->getGeographicalArea();

    //     if ($material !== null) {
    //         $announces = $announceRepository->findByMaterialAndPostalCode($material, $postalCode);
    //     } else {
    //         $announces = [];
    //     }

    //     return $this->render('annonce_chercher/index.html.twig', [
    //         'searchForm' => $searchForm->createView(),
    //         'materials' => $materials,
    //         'announces' => json_encode($announces),
    //     ]);
    // }
