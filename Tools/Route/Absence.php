<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\AbsenceTypeController;
use LibertAPI\Tools\Controllers\AbsencePeriodeController;
use Slim\Routing\RouteCollectorProxy;

/*
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier
 */

/* Routes sur une absence et associés */
$app->group('/absence', function (RouteCollectorProxy $absence): void {
    /* Route sur un type d'absence */
    $absence->group('/type', function (RouteCollectorProxy $type): void {
        /* Détail */
        $type->group('/{typeId:[0-9]+}', function (RouteCollectorProxy $typeId): void {
            $typeId->get('', [AbsenceTypeController::class, 'get'])->setName('getAbsenceTypeDetail');
            $typeId->put('', [AbsenceTypeController::class, 'put'])->setName('putAbsenceTypeDetail');
            $typeId->delete('', [AbsenceTypeController::class, 'delete'])->setName('deleteAbsenceTypeDetail');
        });
        /* Collection */
        $type->get('', [AbsenceTypeController::class, 'get'])->setName('getAbsenceTypeListe');
        $type->post('', [AbsenceTypeController::class, 'post'])->setName('postAbsenceTypeListe');
    });

    /* Route pour une période d'absence */
    $absence->group('/periode', function (RouteCollectorProxy $periode): void {
        /* Détail */
        $periode->get('/{periodeId:[0-9]+}', [AbsencePeriodeController::class, 'get'])->setName('getAbsencePeriodeDetail');
        /* Collection */
        $periode->get('', [AbsencePeriodeController::class, 'get'])->setName('getAbsencePeriodeListe');
    });
});
