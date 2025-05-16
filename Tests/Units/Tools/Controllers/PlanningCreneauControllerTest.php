<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use DomainException;
use LibertAPI\Planning\Creneau\CreneauEntite;
use LibertAPI\Planning\Creneau\CreneauRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\PlanningCreneauController;
use LibertAPI\Tools\Exceptions\MissingArgumentException;
use LibertAPI\Utilisateur\UtilisateurEntite;
use LogicException;
use Psr\Http\Message\ResponseInterface as IResponse;
use LibertAPI\Tools\Exceptions\UnknownResourceException;

/**
 * Classe de test du contrôleur de créneau de planning
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
final class PlanningCreneauControllerTest extends RestControllerTestCase
{
    protected string $testedClass = PlanningCreneauController::class;

    protected function initRepository()
    {
        $this->repository = $this->createMock(CreneauRepository::class);
    }

    protected function initEntite()
    {
        $this->entite = $this->createMock(CreneauEntite::class);

        $this->entite->method('getId')->willReturn(42);
        $this->entite->method('getPlanningId')->willReturn(12);
        $this->entite->method('getJourId')->willReturn(12);
        $this->entite->method('getTypeSemaine')->willReturn(12);
        $this->entite->method('getTypePeriode')->willReturn(12);
        $this->entite->method('getDebut')->willReturn(12);
        $this->entite->method('getFin')->willReturn(12);
    }

    protected function getOne() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, ['creneauId' => 99, 'planningId' => 45]);
    }

    protected function getList() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, ['planningId' => 45]);
    }

    /*************************************************
     * POST
     *************************************************/

    // post ok

    /**
     * Teste la méthode post d'un json mal formé
     */
    public function testPostJsonBadformat()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn(null);

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, ['planningId' => 11]);

        $this->assertFail($response, 400);
    }

    /**
     * Teste la méthode post avec un argument de body manquant
     */
    public function testPostMissingArgument()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([[]]);

        $this->repository
            ->method('postList')
            ->willReturnCallback(fn () => throw new MissingArgumentException());

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, ['planningId' => 11]);

        $this->assertFail($response, 412);
    }

    /**
     * Teste la méthode post avec un argument de body incohérent
     */
    public function testPostBadDomain()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([[]]);

        $this->repository
            ->method('postList')
            ->willReturnCallback(fn () => throw new DomainException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, ['planningId' => 11]);

        $this->assertFail($response, 412);
    }

    /**
     * Teste le fallback de la méthode post
     */
    public function testPostFallback()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([[]]);

        $this->repository
            ->method('postList')
            ->willReturnCallback(fn () => throw new LogicException('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, ['planningId' => 11]);

        $this->assertError($response);
    }

    /**
     * Teste la méthode post tout ok
     */
    public function testPostOk()
    {
        $this->request
            ->method('getParsedBody')
            ->willReturn([[]]);

        $this->router
            ->method('urlFor')
            ->willReturn('');

        $this->repository
            ->method('postList')
            ->willReturn([42, 74, 314]);

        $this->newTestedInstance();

        $response = $this->testedInstance->post($this->request, $this->response, ['planningId' => 11]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals(201, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertNotEmpty($data['data']);
        $this->assertCount(3, $data['data']);
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

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

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

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

        $this->assertTrue($response->isNotFound());
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
            ->willReturnCallback(fn () => throw new MissingArgumentException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

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

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

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

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

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

        $response = $this->testedInstance->put($this->request, $this->response, ['creneauId' => 99, 'planningId' => 11]);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEquals(204, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('', $data['data']);
    }

    final protected function getEntiteContent() : array
    {
        return [
            'id' => 42,
            'planningId' => 12,
            'jourId' => 7,
            'typeSemaine' => 23,
            'typePeriode' => 2,
            'debut' => 98,
            'fin' => 123,
        ];
    }
}
