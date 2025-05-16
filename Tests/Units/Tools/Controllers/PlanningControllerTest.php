<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use DI\NotFoundException;
use DomainException;
use Exception;
use LibertAPI\Planning\PlanningEntite;
use LibertAPI\Planning\PlanningRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\PlanningController;
use LibertAPI\Tools\Exceptions\MissingArgumentException;
use LogicException;
use Psr\Http\Message\ResponseInterface as IResponse;
use LibertAPI\Tools\Exceptions\UnknownResourceException;

/**
 * Classe de test du contrôleur de planning
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
final class PlanningControllerTest extends RestControllerTestCase
{
    protected string $testedClass = PlanningController::class;

    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(PlanningRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = $this->createMock(PlanningEntite::class);
        $this->entite
            ->method('getId')
            ->willReturn(42);

        $this->entite
            ->method('getName')
            ->willReturn(12);

        $this->entite
            ->method('getStatus')
            ->willReturn(12);
    }

    /*************************************************
     * GET
     *************************************************/

    protected function getOne() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, ['planningId' => 99]);
    }

    protected function getList() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, []);
    }

    /*************************************************
     * POST
     *************************************************/

    /**
     * Teste la méthode post d'un json mal formé
     */
    public function testPostJsonBadFormat()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn(null);

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, []);

        $this->assertFail($response, 400);
    }

    /**
     * Teste la méthode post avec un argument de body manquant
     */
    public function testPostMissingRequiredArg()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('postOne')
            ->willReturnCallback(fn () => throw new MissingArgumentException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, []);

        $this->assertFail($response, 412);
    }

    /**
     * Teste la méthode post avec un argument de body incohérent
     */
    public function testPostBadDomain()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('postOne')
            ->willReturnCallback(fn () => throw new DomainException('Status doit être un int'));

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, []);

        $this->assertFail($response, 412);
    }

    /**
     * Teste la méthode post Ok
     */
    public function testPostOk()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->router
            ->method('urlFor')
            ->willReturn('url');

        $this->repository
            ->method('postOne')
            ->willReturn(42);

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, []);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals(201, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertNotEmpty($data['data']);
    }

    /**
     * Teste le fallback de la méthode post
     */
    public function testPostFallback()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('postOne')
            ->willReturnCallback(fn () => throw new Exception('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, []);

        $this->assertError($response);
    }

    /*************************************************
     * PUT
     *************************************************/

    /**
     * Teste la méthode put d'un json mal formé
     */
    public function testPutJsonBadFormat()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn(null);

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['planningId' => 99]);

        $this->assertFail($response, 400);
    }

    /**
     * Teste la méthode put avec un argument de body manquant
     */
    public function testPutMissingRequiredArg()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new MissingArgumentException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['planningId' => 99]);

        $this->assertFail($response, 412);
    }

    /**
     * Teste la méthode put avec un argument de body incohérent
     */
    public function testPutBadDomain()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new DomainException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['planningId' => 99]);

        $this->assertFail($response, 412);
    }

    /**
     * Teste le fallback de la méthode putOne du put
     */
    public function testPutPutOneFallback()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn($this->getEntiteContent());

        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new LogicException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['planningId' => 99]);

        $this->assertError($response);
    }

    /**
     * Teste la méthode put Ok
     */
    public function testPutOk()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn($this->getEntiteContent());

        $this->repository
            ->method('getOne')
            ->willReturn($this->entite);

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['planningId' => 99]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEquals(204, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('', $data['data']);
    }

    protected function getEntiteContent() : array
    {
        return [
            'id' => 72,
            'name' => 'name',
            'status' => 59,
        ];
    }

    /*************************************************
     * DELETE
     *************************************************/

    /**
     * Teste la méthode delete avec un détail non trouvé (id en Bad domaine)
     */
    public function testDeleteNotFound()
    {
        $this->repository
            ->method('deleteOne')
            ->willReturnCallback(fn () => throw new UnknownResourceException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->delete($this->request, $this->response, ['planningId' => 99]);

        $this->assertTrue($response->isNotFound());
    }

    /**
     * Teste le fallback de la méthode delete
     */
    public function testDeleteFallback()
    {
        $this->repository
            ->method('deleteOne')
            ->willReturnCallback(fn () => throw new LogicException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->delete($this->request, $this->response, ['planningId' => 99]);

        $this->assertError($response);
    }

    /**
     * Teste la méthode delete Ok
     */
    public function testDeleteOk()
    {
        $this->repository
            ->method('deleteOne')
            ->willReturn(89172);

        $this->newTestedInstance();

        $response = $this->testedInstance->delete($this->request, $this->response, ['planningId' => 99]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
//        $this->assertNotEmpty($data['data']);
    }
}
