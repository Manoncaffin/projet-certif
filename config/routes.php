<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('accueil', '/accueil')
        ->controller('App\Controller\AccueilController::index');

    $routes->add('inscription', '/inscription')
        ->controller('App\Controller\InscriptionController::index');

    $routes->add('connexion', '/connexion.html')
        ->controller('App\Controller\ConnexionController::index');

    $routes->add('mes-annonces', '/mes-annonces')
        ->controller('App\Controller\MesAnnoncesController::index');

    $routes->add('annonce-chercher', '/annonce-chercher')
        ->controller('App\Controller\AnnonceChercherController::index');

    $routes->add('annonce-chercher-modifier', '/annonce-chercher-modifier')
        ->controller('App\Controller\AnnonceChercherModifierController::index');

    $routes->add('annonce-donner', '/annonce-donner')
        ->controller('App\Controller\AnnonceDonnerController::index');

    $routes->add('annonce-donner-modifier', '/annonce-donner-modifier')
        ->controller('App\Controller\AnnonceDonnerModifierController::index');

    $routes->add('annonce-detail', '/annonce-detail')
        ->controller('App\Controller\AnnonceDetail::index');

    $routes->add('annonce-valide', '/annonce-valide')
        ->controller('App\Controller\AnnonceValideController::index');

    $routes->add('messagerie', '/messagerie')
        ->controller('App\Controller\MessagerieController::index');

    $routes->add('messagerie-mobile', '/messagerie-mobile')
        ->controller('App\Controller\MessagerieMobileController::index');

    $routes->add('messages', '/messages')
        ->controller('App\Controller\MessagesController::index');

    $routes->add('modifications-informations', '/modifications-informations')
        ->controller('App\Controller\ModificationsInformationsController::index');

    $routes->add('page-de-confidentialite', '/page-de-confidentialite')
        ->controller('App\Controller\PageDeConfidentialiteController::index');

    $routes->add('profil', '/profil')
        ->controller('App\Controller\ProfilController::index');

};
