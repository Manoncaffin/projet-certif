<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\File;
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

        $giveForm = $this->createForm(GiveType::class, $announce);
        $materials = $materialRepository->findAll();

        $giveForm->handleRequest($request);
        if ($giveForm->isSubmitted() && $giveForm->isValid()) {
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
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la photo.');
                }
            }

            $materialModif = $request->request->all()['material-bio-select'];
            
            if (!$materialModif) {
                $materialModif = $request->request->all()['material-geo-select'];
            }

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialModif]);
            $announce->setMaterial($selectedMaterial);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_mes_annonces', ['id' => $announce->getId()]);
        }

        return $this->render('annonce_donner_modifier/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'announce' => $announce,
            'materials' => $materials,
        ]);
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
}
