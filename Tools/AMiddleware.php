<?php declare(strict_types = 1);
namespace LibertAPI\Tools;

use Psr\Http\Message\ResponseInterface;
use \Slim\App as App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
/**
 * @since 1.0
 */
abstract class AMiddleware
{
    public function __construct(App $app)
    {
        $this->container = $app->getContainer();
    }

    private $container;

    protected function getContainer()
    {
        return $this->container;
    }

    abstract public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface;


}
