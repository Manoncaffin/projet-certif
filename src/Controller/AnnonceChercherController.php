<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\File;
use App\Form\SearchType;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function index(MaterialRepository $materialRepository, Request $request, SluggerInterface $slugger): Response
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
         
            $photoFile = $searchForm->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
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
                    // ... handle exception if something happens during file upload
                    dd('test');   
                }
            }

            $announce->setUser($user);
            $announce->setMaterial($selectedMaterial);
            $announce->setType('chercher');
            
            $this->entityManager->persist($announce);
            $this->entityManager->flush();

            // if (!empty($announce->getDescription())) {
            //     // Persister et flusher l'entité Announce dans la base de données
            //     $this->entityManager->persist($searchForm);
            //     $this->entityManager->flush();

                return $this->redirectToRoute('app_annonce_valide');
            } else {
                // Afficher un message d'erreur si le champ "description" est vide
                $this->addFlash('error', 'Veuillez saisir une description pour votre annonce.');
            }

        return $this->render('annonce_chercher/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'materials' => $materials
        ]);
    }
}