<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use DI\NotFoundException;
use DomainException;
use Exception;
use LibertAPI\Absence\Type\TypeEntite;
use LibertAPI\Absence\Type\TypeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\AbsenceTypeController;
use LibertAPI\Tools\Exceptions\MissingArgumentException;
use LogicException;
use Psr\Http\Message\ResponseInterface as IResponse;
use \LibertAPI\Tools\Exceptions\UnknownResourceException;
use Slim\Routing\RouteContext;

/**
 * Classe de test du contrôleur du type d'absence
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class AbsenceTypeControllerTest extends RestControllerTestCase
{
    protected string $testedClass = AbsenceTypeController::class;
    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(TypeRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = new TypeEntite([
            'id' => 42,
            'type' => 'thieft',
            'libelle' => 'GTA',
            'libelleCourt' => 'vice',
            'typeNatif' => true,
        ]);
    }

    protected function getOne() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, ['typeId' => 99]);
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
        // Le framework fait du traitement, un mauvais json est simplement null
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
        // Le framework fait du traitement, un mauvais json est simplement null
        $this->request
            ->method('getParsedBody')
            ->willReturn(null);

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

        $this->assertFail($response, 400);
    }

    /**
     * Teste la méthode put avec un détail non trouvé (id en Bad domaine)
     */
    public function testPutNotFound()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([]);

        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new UnknownResourceException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

        $this->assertTrue($response->isNotFound());
    }

    /**
     * Teste la méthode put avec un argument de body manquant
     */
    public function testPutMissingRequiredArg()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn($this->getEntiteContent());


        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new MissingArgumentException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

        $this->assertFail($response, 412);
    }

    /**
     * Teste la méthode put avec un argument de body incohérent
     */
    public function testPutBadDomain()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn($this->getEntiteContent());

        $this->repository
            ->method('putOne')
            ->willReturnCallback(fn () => throw new DomainException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

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

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

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
            ->method('putOne')
            ->willReturn($this->entite);

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['typeId' => 99]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEquals(204, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('', $data['data']);
    }

    final protected function getEntiteContent() : array
    {
        return [
            'id' => 87,
            'type' => 'quatre',
            'libelle' => 'chipolata',
            'libelleCourt' => 'cp',
            'typeNatif' => true,
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
            ->willReturnCallback(fn () => throw new UnknownResourceException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->delete($this->request, $this->response, ['typeId' => 99]);

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

        $response = $this->testedInstance->delete($this->request, $this->response, ['typeId' => 99]);

        $this->assertError($response);
    }

    /**
     * Teste la méthode delete Ok
     */
    public function testDeleteOk()
    {
        $this->repository
            ->method('deleteOne')
            ->willReturn(34);

        $this->newTestedInstance();

        $response = $this->testedInstance->delete($this->request, $this->response, ['typeId' => 99]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
//        $this->assertNotEmpty($data['data']);
    }
}
