<?php declare(strict_types = 1);

use LibertAPI\Tools\Controllers\PlanningController;
use LibertAPI\Tools\Controllers\PlanningCreneauController;
use Slim\Routing\RouteCollectorProxy;

/*
 * Doit être importé après la création de $app. Ne créé rien.
 *
 * La convention de nommage est de mettre les routes au singulier
 */

/* Routes sur le planning et associés */
$app->group('/planning', function (RouteCollectorProxy $planning): void {
    $planning->group('/{planningId:[0-9]+}', function (RouteCollectorProxy $planningId): void {
        /* Detail */
        $planningId->get('', [PlanningController::class, 'get'])->setName('getPlanningDetail');
        $planningId->put('', [PlanningController::class, 'put'])->setName('putPlanningDetail');
        $planningId->delete('', [PlanningController::class, 'delete'])->setName('deletePlanningDetail');

        /* Dependances de plannings */
        $planningId->group('/creneau', function (RouteCollectorProxy $creneau): void {
            /* Detail creneaux */
            $creneau->get('/{creneauId:[0-9]+}', [PlanningCreneauController::class, 'get'])->setName('getPlanningCreneauDetail');
            $creneau->put('/{creneauId:[0-9]+}', [PlanningCreneauController::class, 'put'])->setName('putPlanningCreneauDetail');
            //$this->delete('/{creneauId:[0-9]+}', $creneauNS . ':delete')->setName('deletePlanningCreneauDetail');

            /* Collection creneaux */
            $creneau->get('', [PlanningCreneauController::class, 'get'])->setName('getPlanningCreneauListe');
            $creneau->post('', [PlanningCreneauController::class, 'post'])->setName('postPlanningCreneauListe');
        });
    });

    /* Collection */
    $planning->get('', [PlanningController::class, 'get'])->setName('getPlanningListe');
    $planning->post('', [PlanningController::class, 'post'])->setName('postPlanningListe');
});
