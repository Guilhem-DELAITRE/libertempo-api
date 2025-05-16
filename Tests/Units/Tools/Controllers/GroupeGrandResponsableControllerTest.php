<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use Exception;
use LibertAPI\Groupe\GrandResponsable\GrandResponsableEntite;
use LibertAPI\Groupe\GrandResponsable\GrandResponsableRepository;
use LibertAPI\Tests\Units\Tools\Libraries\ControllerTestCase;
use LibertAPI\Tools\Controllers\GroupeGrandResponsableController;
use UnexpectedValueException;

/**
 * Classe de test du contrôleur de grand responsable de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class GroupeGrandResponsableControllerTest extends ControllerTestCase
{
    protected string $testedClass = GroupeGrandResponsableController::class;
    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(GrandResponsableRepository::class);
    }


    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = new GrandResponsableEntite([
            'id' => uniqid(),
            'groupeId' => 91823,
            'login' => 'Parker',
        ]);
    }

    /*************************************************
     * GET
     *************************************************/

    /**
     * Teste la méthode get d'une liste trouvée
     */
    public function testGetFound()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturn([$this->entite]);

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('OK', $data['message']);
        $this->assertCount(1, $data['data']);
        $this->arrayHasKey('login', $data['data']);
    }

    /**
     * Teste la méthode get d'une liste non trouvée
     */
    public function testGetNotFound()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new UnexpectedValueException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);

        $this->assertSuccessEmpty($response);
    }

    /**
     * Teste le fallback de la méthode get d'une liste
     */
    public function testGetFallback()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new Exception('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);
        $this->assertError($response);
    }
}
