<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ResearchFormType;

class RechercherController extends AbstractController
{
    #[Route('/rechercher', name: 'app_rechercher')]
    public function search(Request $request)
    {
        $form = $this->createForm(ResearchFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Récupérez les données du formulaire et effectuez la recherche ici

            return $this->render('rechercher/resultats.html.twig', [
                'results' => $results,
            ]);
        }
        return $this->render('rechercher/index.html.twig', [
            'controller_name' => 'RechercherController',
            'form' => $form->createView(),
        ]);
    }
}
