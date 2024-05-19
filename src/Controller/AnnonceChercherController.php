<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\SearchType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceChercherController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce_chercher', name: 'app_annonce_chercher')]
    public function index(MaterialRepository $materialRepository, AnnounceRepository $announceRepository, Request $request, SluggerInterface $slugger): Response
    {

        $materials = $materialRepository->findAll();
        $user = $this->getUser();

        $announce = new Announce();
        $searchForm = $this->createForm(SearchType::class, $announce);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $announce = $searchForm->getData();

            $materialAnnounce = $request->request->all()['material-bio-select'];

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);

            $announce->setUser($user);
            $announce->setMaterial($selectedMaterial);
            $announce->setType('chercher');

            // Vérifier si une annonce similaire existe déjà
            $existingAnnounce = $this->entityManager->getRepository(Announce::class)->findOneBy([
                'user' => $user,
                'material' => $selectedMaterial,
                'type' => 'chercher',
            ]);

            if (!$existingAnnounce) {
                // Si aucune annonce similaire n'existe, enregistrer la nouvelle annonce
                $this->entityManager->persist($announce);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_annonce_valide');
            } else {
                // Afficher un message d'erreur si une annonce similaire existe déjà
                $this->addFlash('error', 'Vous avez déjà publié une annonce pour ce matériau.');
            }
        }

        // Récupérer les annonces en fonction du matériau et du code postal saisis
        $material = $announce->getMaterial();
        $postalCode = $announce->getgeographicalArea();

        if ($material && $postalCode) {
            $announce = $this->entityManager->getRepository(Announce::class)->findByMaterialAndPostalCode($material, $postalCode);
        } elseif ($material) {
            $announce = $this->entityManager->getRepository(Announce::class)->findByMaterial($material);
        } elseif ($postalCode) {
            $announce = $this->entityManager->getRepository(Announce::class)->findByPostalCode($postalCode);
        }

        return $this->render('annonce_chercher/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'materials' => $materials,
            'announce' => $announce
        ]);
    }
}