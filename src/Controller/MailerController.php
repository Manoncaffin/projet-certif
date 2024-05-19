<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function sendRegistrationConfirmationEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Confirmation d\'inscription à Bennes solidaires')
            ->html(sprintf('<p>Bonjour %s,</p><p>Votre inscription à Bennes solidaires a bien été prise en compte. Vous pouvez désormais déposer des annonces et échanger avec les autres membres de la communauté.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));

        $mailer->send($email);
    }

    public function sendRegistrationUpdateMail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Prise en compte de vos modifications')
            ->html(sprintf('<p>Bonjour %s,</p><p>À votre demande, les informations liées à votre compte ont bien été modifiées.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));

        $mailer->send($email);
    }

    public function sendRegistrationDeleteMail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Suppression de votre compte')
            ->html(sprintf('<p>Bonjour %s,</p><p>À votre demande, votre désinscription a bien été prise en compte.</p><p>Nous espérons que vous avez apprécié votre expérience sur Bennes solidaires !</p>', $userIdentifier));

        $mailer->send($email);
    }

    public function sendAnnounceConfirmationMail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Confirmation de réception de votre annonce')
            ->html(sprintf('<p>Bonjour %s,</p><p>Votre annonce a bien été réceptionnée et nous vous en remercions. Elle sera publiée dans les prochaines heures.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));
            
        $mailer->send($email);
    }

    public function sendAnnounceUpdateEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Prise en compte de vos modifications')
            ->html(sprintf('<p>Bonjour %s,</p><p>À votre demande, les informations liées à votre annonce ont bien été modifiées.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));
            
        $mailer->send($email);
    }

    public function sendAnnounceDeleteEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Suppression de votre annonce')
            ->html(sprintf('<p>Bonjour %s,</p><p>À votre demande, votre annonce a bien été supprimée.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));
            
        $mailer->send($email);
    }

    public function sendAnnounceNotAcceptEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Votre annonce ne remplie pas les critères')
            ->html(sprintf('<p>Bonjour %s,</p><p>L\'annonce que vous avez tenté de poster ne peut pas être publiée car elle ne remplie pas la charte de Bennes solidaires. Si vous avez des questions, n\'hésitez pas à nous contacter.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));
            
        $mailer->send($email);
    }

    public function confirmationReceptionEmail(MailerInterface $mailer, string $userIdentifier, string $userEmail): void
    {
        $email = (new Email())
            ->from('bennes-solidaires@contact.fr')
            ->to($userEmail)
            ->subject('Votre annonce a été publiée')
            ->html(sprintf('<p>Bonjour %s,</p><p>Votre annonce vient d\'être publiée.</p><p>À bientôt sur Bennes solidaires !</p>', $userIdentifier));
            
        $mailer->send($email);
    }
}
