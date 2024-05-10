<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ModificationsInformationsController extends AbstractController
{
    #[Route('/modifications-informations', name: 'app_modifications_informations')]

    public function update(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        if(!$user->getUserIdentifier()) {
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('modifications_informations/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
