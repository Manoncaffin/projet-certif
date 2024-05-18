<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/email')]
    public function sendRegistrationConfirmationEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Confirmation d\'inscription à Bennes solidaires')
            ->html(sprintf('<p>Bonjour %s,</p><p>Votre inscription à Bennes solidaires a bien été prise en compte. Vous pouvez désormais déposer des annonces et échanger avec les autres membres de la communauté.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));

        $mailer->send($email);

        // ...
    }

    public function sendRegistrationUpdateMail() {

    }

    public function sendRegistrationDeleteMail() {

    }

    public function sendAnnounceConfirmationMail() {

    }

    public function sendAnnounceUpdateEmail() {

    }

    public function sendAnnounceDeleteEmail() {

    }

    public function sendAnnounceNotAcceptEmail() {

    }

    public function confirmationReceptionEmail() {

    }
}