<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ResearchFormType;
use App\Repository\AnnounceRepository;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RechercherController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/rechercher', name: 'app_rechercher')]
    public function search(Request $request, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {
        $researchForm = $this->createForm(ResearchFormType::class);
        $researchForm->handleRequest($request);

        $materials = $materialRepository->findAll();
        $announces = [];

        $announcesJson = '';
        $selectedMaterial = null;
        if($researchForm->isSubmitted() && $researchForm->isValid()) {
            
            $selectedMaterial = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');
            $announcesJson = json_encode($announces);
            $materialAnnounce = $request->request->all()['material-bio-select'];
            if(!$materialAnnounce) {
                $materialAnnounce = $request->request->all()['material-geo-select'];
            }


            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);
            // dd($selectedMaterial);
            $postalCode = $researchForm->get('geographicalArea')->getData();

            // Récupérer les annonces en fonction du matériau sélectionné et du code postal
            $announces = $announceRepository->findByMaterialAndPostalCode($selectedMaterial, $postalCode);
            
            // Convertir les annonces en tableau JSON et les ajouter à la vue Twig
            $announcesJson = json_encode($announces);
            // dump($announces);
        }

        return $this->render('rechercher/index.html.twig', [
            'controller_name' => 'RechercherController',
            'researchForm' => $researchForm->createView(),
            'materials' => $materials,
            'selectedMaterial' => $selectedMaterial,
            'announces' => $announces,
            'announcesJson' => $announcesJson,
        ]);
    }
}
