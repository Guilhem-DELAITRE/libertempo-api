<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\UtilisateurController;
use LibertAPI\Tools\Controllers\UtilisateurEmployeController;
use Slim\Routing\RouteCollectorProxy;

/*
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier
 */

/* Routes sur l'utilisateur et associés */

$app->group('/utilisateur', function (RouteCollectorProxy $utilisateur): void {
    // DEPRECATED depuis 1.10. Remplacé par /employe/me
    $utilisateur->group('/{utilisateurId:[0-9]+}', function (RouteCollectorProxy $utilisateurId): void {
        /* Detail */
        $utilisateurId->get('', [UtilisateurController::class, 'get'])->setName('getUtilisateurDetail');
    });

    /* Collection */
    $utilisateur->get('', [UtilisateurController::class, 'get'])->setName('getUtilisateurListe');
});

$app->get('/employe/me', [UtilisateurEmployeController::class, 'get'])->setName('getEmployeMeDetail');
