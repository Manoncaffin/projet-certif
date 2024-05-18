<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastIdentifier = $authenticationUtils->getLastUsername();

        if ($request->isMethod('POST')) {
            $identifier = $request->request->get('identifier');
            $password = $request->request->get('password');
            $rememberMe = $request->request->get('_remember_me', false);

            // Récupérer l'utilisateur à partir de l'identifiant
            $user = $entityManager->getRepository(User::class)
                ->findOneBy(['identifier' => $identifier]);

            // Vérifier que l'utilisateur existe et que le mot de passe est valide
            if ($user instanceof PasswordAuthenticatedUserInterface && password_verify($password, $user->getPassword())) {
                // Créer un token d'authentification
                $token = new AbstractToken();
                $token->setUser($user);
                $token->setAttribute('authenticated', true);

                // Tenter de se connecter avec le token
                $authChecker = $this->container->get('security.authorization_checker');
                if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY', $token)) {
                    // La connexion a réussi, enregistrer le token dans la session
                    $this->tokenStorage->setToken($token);

                    // Créer un cookie de rappel si l'utilisateur a coché la case "Se souvenir de moi"
                    if ($rememberMe) {
                        $tokenValue = bin2hex(random_bytes(32)); // Générer un jeton d'authentification aléatoire
                        $user->setRememberMeToken($tokenValue); // Stocker le jeton dans l'entité utilisateur
                        $entityManager->flush(); // Enregistrer l'entité utilisateur dans la base de données

                        $cookie = new Cookie(
                            '_remember_me',
                            $tokenValue,
                            time() + 60 * 60 * 24 * 7 // Cookie valable 1 semaine
                        );
                        $response = $this->redirectToRoute('app_accueil');
                        $response->headers->setCookie($cookie);
                        return $response;
                    }

                    // Rediriger vers la page d'accueil
                    return $this->redirectToRoute('app_accueil');
                }
            }
        }

        // Afficher le formulaire de connexion
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