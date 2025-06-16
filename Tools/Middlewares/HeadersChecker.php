<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Vérification des headers
 *
 * @since 1.0
 */
final class HeadersChecker extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if ('application/json' === $request->getHeaderLine('Accept')) {
            return $handler->handle($request);
        }
        return call_user_func(
            $this->getContainer()->get('badRequestHandler'),
            $request,
            $handler
        );
    }
}
