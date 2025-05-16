<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Libraries;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use LibertAPI\Tests\Units\TestCase;
use LibertAPI\Tools\Controllers\GroupeEmployeController;
use LibertAPI\Tools\Libraries\Controller;
use LibertAPI\Tools\Libraries\AEntite;
use LibertAPI\Tools\Libraries\ARepository;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Http\Response;
use Slim\Interfaces\RouteResolverInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Stream;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteResolver;

/**
 * Classe de base des tests sur les contrôleurs
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
abstract class ControllerTestCase extends TestCase
{
    protected Request $request;

    protected ResponseInterface $response;

    protected RouteResolverInterface|MockObject $router;

    protected ARepository $repository;

    protected AEntite $entite;

    protected  EntityManager $entityManager;

    protected EntityRepository $entityRepository;

    protected string $testedClass;

    protected Controller $testedInstance;

    /**
     * Init des tests
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createMock(Request::class);

        $this->response = new Response(new \Slim\Psr7\Response(), new StreamFactory());

        $this->router = $this->createMock(RouteParser::class);

        $this->entityManager = $this->createMock(EntityManager::class);

        $this->entityRepository = $this->createMock(EntityRepository::class);

        $this->entityManager
            ->method('getRepository')
            ->willReturn($this->entityRepository);

        $this->initRepository();
        $this->initEntite();
    }

    public function newTestedInstance()
    {
        $this->testedInstance = new $this->testedClass($this->repository, $this->router, $this->entityManager);
    }

    /**
     * Initialise un repo bien formé au sens du contrôleur testé
     */
    abstract protected function initRepository();

    /**
     * Initialise une entité bien formée au sens du contrôleur testé
     */
    abstract protected function initEntite();

    /**
     * Retourne le json décodé
     *
     * @param $json
     *
     * @return mixed si le json est mal formé
     */
    protected function getJsonDecoded($json) : mixed
    {
        return json_decode((string) $json, true);
    }

    /**
     * Lance un pool d'assertion d'échec
     *
     * @param IResponse $response Réponse Http
     * @param int $code Code d'erreur Http attendu
     */
    protected function assertFail(IResponse $response, $code): void
    {
        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals($code, $response->getStatusCode());

        $this->assertEquals($code, $data['code']);
        $this->assertEquals('fail', $data['status']);
        $this->assertNotEmpty($data['data']);
    }

    /**
     * Lance un pool d'assertion d'erreur
     *
     * @param IResponse $response Réponse Http
     */
    protected function assertError(IResponse $response): void
    {
        $data = $this->getJsonDecoded($response->getBody());
        $code = 500;

        $this->assertEquals($code, $response->getStatusCode());

        $this->assertEquals($code, $data['code']);
        $this->assertEquals('error', $data['status']);
        $this->assertNotEmpty($data['data']);
    }

    /**
     * Lance un pool d'assertion vide
     *
     * @param IResponse $response Réponse Http
     */
    protected function assertSuccessEmpty(IResponse $response): void
    {
        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(204, $response->getStatusCode());

        $this->assertEquals(204, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('No Content', $data['message']);
    }
}
