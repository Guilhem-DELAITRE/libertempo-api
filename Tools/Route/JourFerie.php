<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\JourFerieController;
use Slim\Routing\RouteCollectorProxy;

/**
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier.
 */

/* Route sur le jour férié */
$app->group('/jour_ferie', function (RouteCollectorProxy $jourFerie): void {
    /* Collection */
    $jourFerie->get('', [JourFerieController::class, 'get'])->setName('getJourFerieListe');
});
