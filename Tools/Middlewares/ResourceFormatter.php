<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use \LibertAPI\Tools\Helpers\Formatter;
use Rollbar\ResponseHandlerInterface;

/**
 * Découvre et met en forme les noms des ressources
 *
 * @since 1.0
 */
final class ResourceFormatter extends \LibertAPI\Tools\AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $path = trim(trim($request->getUri()->getPath()), '/');
        $api = 'api/';
        $position = mb_stripos($path, $api);
        if (false !== $position) {
            $uriUpdated = $request->getUri()->withPath('/' . substr($path, $position + strlen($api)));
            $request = $request->withUri($uriUpdated);
            $path = trim(trim($request->getUri()->getPath()), '/');
        }
        $paths = explode('/', $path);
        $ressources = [];
        foreach ($paths as $value) {
            if (!is_numeric($value)) {
                $ressources[] = Formatter::getStudlyCapsFromSnake($value);
            }
        }
        $request = $request->withAttribute('nomRessources', implode('|', $ressources));

        return $handler->handle($request);
    }
}
