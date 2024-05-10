<?php

namespace App\Controller;

use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfilController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils, AnnounceRepository $announceRepository)
    {
        $user = $this->getUser();
        $userAnnounces = $announceRepository->findByUser($user);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'userAnnounces' => $userAnnounces,
        ]);
    }
}
