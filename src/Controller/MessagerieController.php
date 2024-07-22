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

    #[Route('/messagerie/{id}', name: 'app_messagerie_show', methods: ['GET'])]
    public function show(int $id, AnnounceRepository $announceRepository): Response
    {
        $announce = $announceRepository->find($id);

        if (!$announce) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas.');
        }

        return $this->render('messagerie/show.html.twig', [
            'announce' => $announce,
        ]);
    }

    #[Route('/messagerie/supprimer/{id}', name: 'messagerie_supprimer', methods: ['DELETE'])]
    public function delete($id, LoggerInterface $logger): JsonResponse
    {
        $announce = $this->entityManager->getRepository(Announce::class)->find($id);

        if (!$announce) {
            $logger->error("Announce with id $id not found.");
            return new JsonResponse(['success' => false, 'error' => 'Announce not found'], 404);
        }

        try {
            $this->entityManager->remove($announce);
            $this->entityManager->flush();

        } catch (\Exception $e) {
            $logger->error("Error deleting announce: " . $e->getMessage());
            return new JsonResponse(['success' => false, 'error' => 'Error deleting announce'], 500);
        }

        return new JsonResponse(['success' => true]);
    }
}
