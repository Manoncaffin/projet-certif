<?php
// Exemple de fichier config/routes.php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('accueil', '/')
        ->controller('App\Controller\AccueilController::index');

    $routes->add('inscription', '/')
        ->controller('App\Controller\InscriptionController::index');

    $routes->add('connexion', '/')
        ->controller('App\Controller\ConnexionController::index');

    $routes->add('mes_annonces', '/mes-annonces')
        ->controller('App\Controller\MesAnnoncesController::index');

    // Ajoutez d'autres routes au besoin
};

?>