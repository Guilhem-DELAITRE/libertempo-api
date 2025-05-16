<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Libraries;

use _PHPStan_ea7072c0a\Nette\UnexpectedValueException;
use Exception;
use LibertAPI\Utilisateur\UtilisateurEntite;
use Psr\Http\Message\ResponseInterface as IResponse;
use \LibertAPI\Tools\Exceptions\UnknownResourceException;

/**
 * Classe de base des tests sur les contrôleurs REST
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.4
 */
abstract class RestControllerTestCase extends ControllerTestCase
{
    /*************************************************
     * GET
     *************************************************/

    /**
     * Teste la méthode get d'un détail trouvé
     */
    public function testGetOneFound()
    {
        $this->repository
            ->method('getOne')
            ->willReturn($this->entite);

        $this->newTestedInstance();

        $response = $this->getOne();

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertNotEmpty($data['data']);
    }

    /**
     * Teste la méthode get d'un détail non trouvé
     */
    public function testGetOneNotFound()
    {
        $this->repository
            ->method('getOne')
            ->willReturnCallback(fn () => throw new UnknownResourceException());

        $this->newTestedInstance();

        $response = $this->getOne();

        $this->assertFail($response, 404);
    }

    /**
     * Teste le fallback de la méthode get d'un détail
     */
    public function testGetOneFallback()
    {
        $this->repository
            ->method('getOne')
            ->willReturnCallback(fn () => throw new Exception('e'));

        $this->newTestedInstance();

        $response = $this->getOne();

        $this->assertError($response);
    }

    abstract protected function getOne() : IResponse;

    /**
     * Teste la méthode get d'une liste trouvée
     */
    public function testGetListFound()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturn([$this->entite]);

        $this->newTestedInstance();

        $response = $this->getList();

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertCount(1, $data['data']);
        $this->assertFalse(empty($data['data']));
    }

    /**
     * Teste la méthode get d'une liste vide
     */
    public function testGetListNoContent()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new UnexpectedValueException(''));

        $this->newTestedInstance();

        $response = $this->getList();

        $this->assertSuccessEmpty($response);
    }

    /**
     * Teste le fallback de la méthode get d'une liste
     */
    public function testGetListFallback()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new Exception('e'));

        $this->newTestedInstance();

        $response = $this->getList();

        $this->assertError($response);
    }

    abstract protected function getList() : IResponse;

    abstract protected function getEntiteContent() : array;
}
