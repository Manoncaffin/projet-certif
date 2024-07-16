<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Controller\MailerController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier, private MailerController $mailerController)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer, Security $security, EntityManagerInterface $entityManager, #[Autowire('%photo_directory%')] string $photoDir): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professional = $form->get('professional')->getData();
            $user->setProfessional($professional);

            $fileName = null;
            if ($avatar = $form['avatar']->getData()) {
                $fileName = uniqid().'.'.$avatar->guessExtension();
                $avatar->move($photoDir, $fileName);
            }
            $user->setAvatar($fileName);

            $status = $request->request->all()['registration_form']['professional'];
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setProfessional($status);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoi de l'e-mail de confirmation d'inscription
            $this->mailerController->sendRegistrationConfirmationEmail($mailer, $user->getUserIdentifier(), $user->getEmail());

            return $this->redirectToRoute('app_login');
            // Envoi de l'e-mail de confirmation d'inscription

            return $security->login($user, AppAuthenticator::class, 'main');
        } else {
            $errors = $form->getErrors();
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse e-mail a bien été vérifiée.');

        return $this->redirectToRoute('app_login');
    }
}
