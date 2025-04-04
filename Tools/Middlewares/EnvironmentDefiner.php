<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use \Rollbar\Rollbar;

/**
 * Définit toutes les particularités d'environnement
 *
 * @since 1.5
 */
final class EnvironmentDefiner extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $configuration = $this->getContainer()->get('configurationFileData');
        $stage = (!isset($configuration->stage) || 'development' !== $configuration->stage)
            ? 'production'
            : 'development';
        if ('development' == $stage) {
            $this->defineDevelopment();
        } else {
            $this->defineProduction();
        }

        return $handler->handle($request);
    }

    private function defineDevelopment()
    {
        ini_set('assert.exception', '1');
        error_reporting(-1);
        ini_set("display_errors", '1');
        $configuration = $this->getContainer()->get('configurationFileData');
        if (!empty($configuration->logger_token)) {

            Rollbar::init([
                'access_token' => $configuration->logger_token,
                'environment' => 'development',
                'use_error_reporting' => true,
                'allow_exec' => false,
                'included_errno' => E_ALL,
            ]);
            \Rollbar\Rollbar::addCustom('access_key', $configuration->logger_token);
        }
    }

    private function defineProduction()
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
        ini_set("display_errors", '0');
    }
}
