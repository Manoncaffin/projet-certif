<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\GiveType;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/annonce-donner-modifier/{id}', name: 'app_annonce_donner_modifier', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, SluggerInterface $slugger): Response
{
    $announce = $this->entityManager->getRepository(Announce::class)->find($id);

    if (!$announce) {
        throw $this->createNotFoundException('L\'annonce demandée n\'existe pas.');
    }

    $giveForm = $this->createForm(GiveType::class, $announce);
    $giveForm->handleRequest($request);

    if ($giveForm->isSubmitted() && $giveForm->isValid()) {

        $this->entityManager->flush();

        return $this->redirectToRoute('app_annonce_valide');
    }

    return $this->render('annonce_donner/index.html.twig', [
        'giveForm' => $giveForm->createView(),
        'announce' => $announce,
    ]);
}
}
