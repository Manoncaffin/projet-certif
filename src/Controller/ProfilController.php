<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function index(AuthenticationUtils $authenticationUtils, AnnounceRepository $announceRepository)
    {
        $user = $this->getUser();
        $userAnnounces = $announceRepository->findByUser($user);

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'userAnnounces' => $userAnnounces,
        ]);
    }

    public function uploadPhoto(Request $request, EntityManagerInterface $entityManager, User $user)
{

    $user = $this->getUser();
    $avatarFile = $request->files->get('photo');

    if ($avatarFile) {
        $originalAvatar = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeAvatar = $this->slugger->slug($originalAvatar);
        $newAvatar = $safeAvatar.'-'.uniqid().'.'.$avatarFile->guessExtension();

        try {
            $avatarFile->move($this->getParameter('photo_directory'), $newAvatar);
        } catch (FileException $e) {
        }

        $user->setAvatar($newAvatar);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_profil');
}
}
