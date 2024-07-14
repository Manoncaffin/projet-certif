<?php

// src/Controller/AnnonceChercherController.php
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

    private function findMaterialByPartialName($materialName)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('m')
            ->from(Material::class, 'm')
            ->where($qb->expr()->like('m.material', ':material'))
            ->setParameter('material', '%'.$materialName.'%');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    #[Route('/annonce-chercher', name: 'app_annonce_chercher')]
    public function index(Request $request, EntityManagerInterface $entityManager, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {
        $materials = $materialRepository->findAll();
        $user = $this->getUser();

        $announce = new Announce();
        $searchForm = $this->createForm(SearchType::class, $announce);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            if ($searchForm->isValid() && $user) {
                $announce = $searchForm->getData();

                $materialAnnounce = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');

                if ($materialAnnounce) {
                    $selectedMaterials = $this->findMaterialByPartialName($materialAnnounce);

                    if (count($selectedMaterials) === 1) {
                        $selectedMaterial = $selectedMaterials[0];
                    } else {
                        $this->addFlash('error', 'Plusieurs matériaux correspondent à votre sélection. Veuillez être plus précis.');
                        return $this->redirectToRoute('app_annonce_chercher');
                    }

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
                } else {
                    $this->addFlash('error', 'Veuillez sélectionner un matériau.');
                }
            } else {
                $this->addFlash('error', 'Formulaire invalide ou utilisateur non connecté.');
            }
        } else {
            $this->addFlash('error', 'Formulaire non soumis.');
        }

        return $this->render('annonce_chercher/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'materials' => $materials,
        ]);
    }
}
