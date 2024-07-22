<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ModificationsInformationsController extends AbstractController
{
    #[Route('/modifications-informations', name: 'app_modifications_informations')]

    public function update(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        if ($this->getUser()) {
            $form->remove('agreeTerms');
        }
        
        $form->handleRequest($request);

        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        if(!$user->getUserIdentifier()) {
            return $this->redirectToRoute('app_accueil');
        }

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();

            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();

        $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

        return $this->redirectToRoute('app_profil');
    }
        return $this->render('modifications_informations/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
