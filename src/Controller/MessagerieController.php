<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagerieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/messagerie', name: 'app_messagerie')]
    public function index(AnnounceRepository $announceRepository): Response
    {
        // $announces = $this->entityManager->getRepository(Announce::class)->findAll();
        // $user = $this->getUser();

        $user = $this->getUser();
        $announces = $announceRepository->findByOtherUsers($user);

        return $this->render('messagerie/index.html.twig', [
            'controller_name' => 'MessagerieController',
            'announces' => $announces,
        ]);
    }

    #[Route('/messagerie/{id}', name: 'app_messagerie_show')]
    public function messagerie(int $id): Response
    {
        $announce = $this->entityManager->getRepository(Announce::class)->find($id);
        $photos = $announce->getPhoto();

        if (!$announce) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas.');
        }

        return $this->render('messagerie/show.html.twig', [
            'controller_name' => 'MessagerieController',
            'announce' => $announce,
            'photos' => $photos,
        ]);
    }
}
