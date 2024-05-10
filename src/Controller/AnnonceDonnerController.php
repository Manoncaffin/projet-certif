<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\File;
use App\Entity\Material;
use App\Form\GiveType;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceDonnerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/annonce-donner', name: 'app_annonce_donner')]
    public function index(MaterialRepository $materialRepository, Request $request, SluggerInterface $slugger): Response
    {
        $materials = $materialRepository->findAll();
        $user = $this->getUser();

        $announce = new Announce();
        $giveForm = $this->createForm(GiveType::class, $announce);
        $giveForm->handleRequest($request);

        if ($giveForm->isSubmitted() && $giveForm->isValid()) {
            
            $materialAnnounce = $request->request->all()['material-bio-select'];

            $selectedMaterial = $materialRepository->findOneBy(['material' => $materialAnnounce]);
         
            $photoFile = $giveForm->get('photo')->getData();
          

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move($this->getParameter('photo_directory'), $newFilename);
                    $photoAnnounce = new File();
                    $photoAnnounce->setUrl($newFilename);
                    $photoAnnounce->setAnnounce($announce);
                    $announce->addPhoto($photoAnnounce);
                    $this->entityManager->persist($photoAnnounce);

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    dd('test');   
                }
            }

            $announce->setUser($user);
            $announce->setMaterial($selectedMaterial);
            $announce->setType('donner');
            
            $this->entityManager->persist($announce);
            $this->entityManager->flush();

                return $this->redirectToRoute('app_annonce_valide');
        } else {
                // Afficher un message d'erreur si le champ "description" est vide
                $this->addFlash('error', 'Veuillez saisir une description pour votre annonce.');
            }
        

        return $this->render('annonce_donner/index.html.twig', [
            'giveForm' => $giveForm->createView(),
            'materials' => $materials
        ]);
    }
}