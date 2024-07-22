<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/messagerie/supprimer/{id}', name: 'messagerie_supprimer', methods: ['DELETE'])]
    public function delete($id, EntityManagerInterface $entityManager, LoggerInterface $logger): JsonResponse
    {
        $announce = $entityManager->getRepository(Announce::class)->find($id);

        if (!$announce) {
            $logger->error("Announce with id $id not found.");
            return new JsonResponse(['success' => false, 'error' => 'Announce not found'], 404);
        }

        try {
            $entityManager->remove($announce);
            $entityManager->flush();
        } catch (\Exception $e) {
            $logger->error("Error deleting announce: " . $e->getMessage());
            return new JsonResponse(['success' => false, 'error' => 'Error deleting announce'], 500);
        }

        return new JsonResponse(['success' => true]);
    }
}
