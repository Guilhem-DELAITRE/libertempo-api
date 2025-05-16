<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\UtilisateurController;
use LibertAPI\Utilisateur\UtilisateurEntite;
use LibertAPI\Utilisateur\UtilisateurRepository;
use Psr\Http\Message\ResponseInterface as IResponse;

/**
 * Classe de test du contrôleur de l'utilisateur
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.6
 */
final class UtilisateurControllerTest extends RestControllerTestCase
{
    protected string $testedClass = UtilisateurController::class;

    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(UtilisateurRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = new UtilisateurEntite([
            'id' => 42,
            'login' => 'I.Gadget',
            'nom' => 'Gadget',
            'prenom' => 'Inspecteur',
            'isResp' => false,
            'isAdmin' => false,
            'isHr' => true,
            'isActif' => true,
            'password' => 'Sophie',
            'quotite' => 400,
            'email' => 'gadget@fino.com',
            'numeroExercice' => '7',
            'planningId' => '88',
            'heureSolde' => 12,
            'dateInscription' => '2018-12-26',
            'dateLastAccess' => '2018-12-26',
        ]);
    }

    protected function getOne() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, ['utilisateurId' => 99]);
    }

    protected function getList() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, []);
    }

    /*************************************************
     * PUT
     *************************************************/


    final protected function getEntiteContent() : array
    {
        return [];
    }
}
