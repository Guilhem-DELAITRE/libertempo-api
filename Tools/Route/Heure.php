<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\HeureReposEmployeController;
use LibertAPI\Tools\Controllers\HeureAdditionnelleEmployeController;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Routing\RouteCollectorProxy;

/*
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier
 */

/* Routes sur l'heure */
$app->group('/employe/me/heure', function (RouteCollectorProxy $heure): void {
    $heure->group('/repos', function (RouteCollectorProxy $repos): void {
        $repos->get('', [HeureReposEmployeController::class, 'get'])->setName('getHeureReposEmployeMeListe');
    });

    $heure->group('/additionnelle', function (RouteCollectorProxy $additionelle): void {
        $additionelle->get('', [HeureAdditionnelleEmployeController::class, 'get'])->setName('getHeureAdditionnelleEmployeMeListe');
    });
});
