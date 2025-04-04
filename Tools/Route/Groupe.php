<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\GroupeController;
use LibertAPI\Tools\Controllers\GroupeGrandResponsableController;
use LibertAPI\Tools\Controllers\GroupeResponsableController;
use LibertAPI\Tools\Controllers\GroupeEmployeController;
use Slim\Routing\RouteCollectorProxy;

/*
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier
 */

/* Routes sur le groupe */
$app->group('/groupe', function (RouteCollectorProxy $groupe): void {
    $groupe->group('/{groupeId:[0-9]+}', function (RouteCollectorProxy $groupeId): void {
        /* Detail */
        $groupeId->get('', [GroupeController::class, 'get'])->setName('getGroupeDetail');

        /* Dependances de groupe : responsable */
        $groupeId->get('/responsable', [GroupeResponsableController::class, 'get'])->setName('getGroupeResponsableListe');

        /* Dependances de groupe : grand responsable */
        $groupeId->get('/grand_responsable', [GroupeGrandResponsableController::class, 'get'])->setName('getGroupeGrandResponsableListe');

        /* Dependances de groupe : employe */
        $groupeId->get('/employe', [GroupeEmployeController::class, 'get'])->setName('getGroupeEmployeListe');
    });

    /* Collection */
    $groupe->get('', [GroupeController::class, 'get'])->setName('getGroupeListe');
});
