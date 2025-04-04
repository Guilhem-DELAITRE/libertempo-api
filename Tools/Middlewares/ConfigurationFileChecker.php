<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Récupère les informations du fichier de configuration
 *
 * @since 1.3
 */
final class ConfigurationFileChecker extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $configuration = ('ci' == $request->getHeaderLine('stage', null))
            ? $this->getTestConfiguration()
            : $this->getRealConfiguration();
        $this->getContainer()->set('configurationFileData', $configuration);

        return $handler->handle($request);
    }

    private function getTestConfiguration() : \stdClass
    {
        return new \stdClass();
    }

    private function getRealConfiguration() : \stdClass
    {
        $configuration = json_decode(file_get_contents(ROOT_PATH . DS . 'configuration.json'));
        if (0 !== json_last_error()) {
            throw new \Exception('Configuration file is not JSON');
        }

        return $configuration;
    }
}
