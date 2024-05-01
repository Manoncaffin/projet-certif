<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModificationsInformationsController extends AbstractController
{
    #[Route('/modifications-informations', name: 'app_modifications_informations')]
    // public function index(): Response
    // {
    //     return $this->render('modifications_informations/index.html.twig', [
    //         'controller_name' => 'ModificationsInformationsController',
    //     ]);
    // }

    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('modifications_informations/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
