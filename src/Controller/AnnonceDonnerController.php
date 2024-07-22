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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceDonnerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce-donner', name: 'app_annonce_donner')]
    public function index(MaterialRepository $materialRepository, VolumeRepository $volumeRepository, Request $request, SluggerInterface $slugger): Response
    {
        $materials = $materialRepository->findAll();
        $user = $this->getUser();

        $announce = new Announce();
        $giveForm = $this->createForm(GiveType::class, $announce);
        $giveForm->handleRequest($request);

        if ($giveForm->isSubmitted() && $giveForm->isValid()) {
            
            $materialAnnounce = $request->request->all()['material-bio-select'];
            if(!$materialAnnounce) {
                $materialAnnounce = $request->request->all()['material-geo-select'];
            }

            $volume = $request->request->all()['give']['volume'];
            $volumes = $volumeRepository->findOneBy(['id' => $volume]);

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);
        
            $photoFile = $giveForm->get('photo')->getData();
        

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

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

                return $this->redirectToRoute('app_annonce_valide');
        } else {
                $this->addFlash('error', 'Le formulaire n/est pas valide.');
            }
        
        return $this->render('annonce_donner/index.html.twig', [
            'giveForm' => $giveForm->createView(),
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