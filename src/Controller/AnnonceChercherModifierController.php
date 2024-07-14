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
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AnnonceChercherModifierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
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

    #[Route('/annonce-chercher-modifier/{id}', name: 'app_annonce_chercher_modifier', requirements: ["id" => "\d+"])]
    public function edit($id, Request $request, Announce $announce, AnnounceRepository $announceRepository, MaterialRepository $materialRepository): Response
    {
        $user = $this->getUser();

    if ($user !== $announce->getUser()) {
        throw $this->createAccessDeniedException();
    }

    if ($announce->getType() !== 'chercher') {
        throw $this->createNotFoundException();
    }

    $searchForm = $this->createForm(SearchType::class, $announce);
    $materials = $materialRepository->findAll();

    $searchForm->handleRequest($request);

    if ($searchForm->isSubmitted() && $searchForm->isValid()) {
        $materialModif = $request->request->get('material-bio-select') ?: $request->request->get('material-geo-select');

        if ($materialModif) {
            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialModif]);

            if ($selectedMaterial) {
                $announce->setMaterial($selectedMaterial);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
            } else {
                $this->addFlash('error', 'Aucun matériau ne correspond à votre sélection.');
            }
        } else {
            $this->addFlash('error', 'Veuillez sélectionner un matériau.');
        }
    }

    return $this->render('annonce_chercher_modifier/index.html.twig', [
        'searchForm' => $searchForm->createView(),
        'announce' => $announce,
        'materials' => $materials,
    ]);
}
}