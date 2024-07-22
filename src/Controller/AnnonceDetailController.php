<?php

namespace App\Controller;

use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnnonceDetailController extends AbstractController
{

    #[Route('/annonce-detail/{id}', name: 'app_annonce_detail')]
    public function index(Request $request, AnnounceRepository $announceRepository, int $id): Response
    {
        $announce = $announceRepository->find($id);

        if (!$announce) {
            throw $this->createNotFoundException('Annonce non trouvée' . $id);
        }

        $user = $this->getUser();

        if ($request->isMethod('POST') && !$user) {
            $this->addFlash('error', 'Vous devez être connecté·e pour envoyer un message.');
            return $this->redirectToRoute('app_annonce_detail', ['id' => $id]);
        }

        return $this->render('annonce_detail/index.html.twig', [
            'user' => $user,
            'announce' => $announce,
        ]);
    }
}
