<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastIdentifier = $authenticationUtils->getLastUsername();

        if ($request->isMethod('POST')) {
            $identifier = $request->request->get('identifier');
            $password = $request->request->get('password');

            $user = $entityManager->getRepository(User::class)->findOneBy(['identifier' => $identifier]);

            if ($user instanceof PasswordAuthenticatedUserInterface && password_verify($password, $user->getPassword())) {
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

                if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY', $token)) {
                    $this->tokenStorage->setToken($token);

                    return $this->redirectToRoute('app_accueil');
                }
            }
        }

        return $this->render('security/login.html.twig', [
            'last_identifier' => $lastIdentifier,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}