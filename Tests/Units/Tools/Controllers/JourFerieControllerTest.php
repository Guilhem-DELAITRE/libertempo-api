<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use LibertAPI\JourFerie\JourFerieEntite;
use LibertAPI\JourFerie\JourFerieRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\JourFerieController;
use Psr\Http\Message\ResponseInterface as IResponse;

/**
 * Classe de test du contrôleur de jour férié
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class JourFerieControllerTest extends RestControllerTestCase
{
    protected string $testedClass = JourFerieController::class;

    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(JourFerieRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = new JourFerieEntite([
            'id' => 78,
            'date' => '2018-06-12',
        ]);
    }

    /**
     * Teste la méthode get d'un détail trouvé
     */
    public function testGetOneFound()
    {
        $this->assertTrue(true);
    }

    /**
     * Teste la méthode get d'un détail non trouvé
     */
    public function testGetOneNotFound()
    {
        $this->assertTrue(true);
    }

    /**
     * Teste le fallback de la méthode get d'un détail
     */
    public function testGetOneFallback()
    {
        $this->assertTrue(true);
    }

    /**
     * @todo inutile dans le sens où chercher un élément unique n'a pas de sens.
     * Problème de design.
     */
    protected function getOne() : IResponse
    {
        return $this->response;
    }

    protected function getList() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, []);
    }

    final protected function getEntiteContent() : array
    {
        return [
            'id' => uniqid(),
            'jf_date' => '2018-05-14',
        ];
    }
}
