<?php declare(strict_types = 1);

use Psr\Container\ContainerInterface as C;
use Doctrine\ORM\EntityManager;
use DI\Container;
use Invoker\CallableResolver;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Interfaces\RouterInterface as IRouter;
use LibertAPI\Tools\Controllers\AuthentificationController;
use LibertAPI\Utilisateur\UtilisateurRepository;
use LibertAPI\Tools\Libraries\Application;
use LibertAPI\Tools\Libraries\StorageConfiguration;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\StreamFactory;
use function DI\get;
use function DI\create;
use function DI\autowire;
use \Rollbar\Rollbar;

return configurationGenerale() + configurationPersonnelle();

function configurationGenerale() : array
{
    return [
        // Settings that can be customized by users
        'settings.httpVersion' => '1.1',
        'settings.responseChunkSize' => 4096,
        'settings.outputBuffering' => 'append',
        'settings.determineRouteBeforeAppMiddleware' => false,
        'settings.displayErrorDetails' => true,
        'settings.addContentLengthHeader' => true,
        'settings.routerCacheFile' => false,

        // Defaults settings
        'settings' => [
            'httpVersion' => get('settings.httpVersion'),
            'responseChunkSize' => get('settings.responseChunkSize'),
            'outputBuffering' => get('settings.outputBuffering'),
            'determineRouteBeforeAppMiddleware' => get('settings.determineRouteBeforeAppMiddleware'),
            'displayErrorDetails' => get('settings.displayErrorDetails'),
            'addContentLengthHeader' => get('settings.addContentLengthHeader'),
            'routerCacheFile' => get('settings.routerCacheFile'),
        ],
        IRouter::class => get('router'),
        'router' => create(Slim\Router::class)
            ->method('setContainer', get(Container::class))
            ->method('setCacheFile', get('settings.routerCacheFile')),
        Slim\Router::class => get('router'),
        'callableResolver' => autowire(CallableResolver::class),
        'environment' => function (C $c) {
            return new Slim\Http\Environment($_SERVER);
        },
        'request' => function (C $c) {
            return Request::createFromEnvironment($c->get('environment'));
        },
        'response' => function (C $c) {
            $headers = new Headers(['Content-Type' => 'application/json; charset=UTF-8']);
            $response = new Response(200, $headers);
            return $response->withProtocolVersion($c->get('settings')['httpVersion']);
        },
    ];
}

function configurationPersonnelle() : array
{
    return configurationHandlers() + configurationLibertempo();
}

function configurationHandlers() : array
{
    return [
        'foundHandler' => create(\Slim\Handlers\Strategies\RequestResponse::class),
        'badRequestHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $response) use ($c) {
                return call_user_func(
                    $c->get('clientErrorHandler'),
                    $request,
                    $response,
                    400,
                    'Request Content-Type and Accept must be set on application/json only'
                );
            };
        },
        'forbiddenHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($c) {
                return call_user_func(
                    $c->get('clientErrorHandler'),
                    $request,
                    $handler,
                    403,
                    'User has not access to « ' . $request->getUri()->getPath() . ' » resource'
                );
            };
        },
        'unauthorizedHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($c) {
                return call_user_func(
                    $c->get('clientErrorHandler'),
                    $request,
                    $handler,
                    401,
                    'Bad API Key'
                );
            };
        },
        'notFoundHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($c) {
                return call_user_func(
                    $c->get('clientErrorHandler'),
                    $request,
                    $handler,
                    404,
                    '« ' . $request->getUri()->getPath() . ' » is not a valid resource'
                );
            };
        },
        'clientErrorHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler, int $code, string $messageData) {
                $responseFactory = new DecoratedResponseFactory(new ResponseFactory(), new StreamFactory());
                $responseUpd = $responseFactory->createResponse();
                $responseUpd = $responseUpd->withStatus($code);
                $data = [
                    'code' => $code,
                    'status' => 'fail',
                    'message' => $responseUpd->getReasonPhrase(),
                    'data' => $messageData,
                ];
                Rollbar::warning($code . ' ' . $messageData);

                return $responseUpd->withJson($data);
            };
        },
        'phpErrorHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler, \Throwable $throwable) use ($c) {
                return call_user_func(
                    $c->get('serverErrorHandler'),
                    $request,
                    $handler,
                    $throwable
                );
            };
        },
        'errorHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler, \Exception $exception) use ($c) {
                return call_user_func(
                    $c->get('serverErrorHandler'),
                    $request,
                    $handler,
                    $exception
                );
            };
        },
        'serverErrorHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler, \Throwable $throwable) {
                Rollbar::error($throwable->getMessage(), ['trace' => substr($throwable->getTraceAsString(), 0, 1000) . '[...]']);

                $responseFactory = new DecoratedResponseFactory(new ResponseFactory(), new StreamFactory());
                $responseUpd = $responseFactory->createResponse();
                $code = 500;
                return $responseUpd->withJson([
                    'code' => $code,
                    'status' => 'error',
                    'message' => $responseUpd->getReasonPhrase(),
                    'data' => $throwable->getMessage(),
                ]);
            };
        },
        'notAllowedHandler' => function (C $c) {
            return function (ServerRequestInterface $request, RequestHandlerInterface $handler, array $methods) use ($c) {
                $methodString = implode(', ', $methods);
                $responseUpd = call_user_func(
                    $c->get('clientErrorHandler'),
                    $request,
                    $handler,
                    405,
                    'Method on « ' . $request->getUri()->getPath() . ' » must be one of : ' . $methodString
                );

                return $responseUpd->withHeader('Allow', $methodString);
            };
        },
    ];
}

function configurationLibertempo() : array
{
    return [
        AuthentificationController::class => function (C $c) {
            $repo = $c->get(UtilisateurRepository::class);
            $repo->setApplication($c->get(Application::class));
            return new AuthentificationController($repo, $c->get(IRouter::class), $c->get(StorageConfiguration::class), $c->get(EntityManager::class));
        },
        Doctrine\DBAL\Connection::class => function (C $c) {
            return $c->get('storageConnector');
        },
        EntityManager::class => get('entityManager'),
    ];
}
