<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Vérifie les autorisations d'accès pour la route et l'utilisateur donnés
 *
 * @since 1.1
 */
final class AccessChecker extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $ressourcePath = $request->getAttribute('nomRessources');
        $container = $this->getContainer();

        switch ($ressourcePath) {
            case 'Absence|Periode':
            case 'Absence|Type':
            case 'Authentification':
            case 'Employe|Me':
            case 'Employe|Me|Heure|Repos':
            case 'Employe|Me|Heure|Additionnelle':
            case 'Employe|Me|Solde':
            case 'HelloWorld':
            case 'Journal':
            case 'Planning|Creneau':
                return $handler->handle($request);
            case 'Groupe':
            case 'Groupe|Employe':
            case 'Groupe|GrandResponsable':
            case 'Groupe|Responsable':
                $user = $request->getAttribute('currentUser');
                if (!$user->isAdmin()) {
                    return call_user_func(
                        $container->get('forbiddenHandler'),
                        $request,
                        $handler
                    );
                }

                return $handler->handle($request);
            case 'JourFerie':
            case 'Utilisateur':
                $user = $request->getAttribute('currentUser');
                if (!$user->isHautResponsable()) {
                    return call_user_func(
                        $container->get('forbiddenHandler'),
                        $request,
                        $handler
                    );
                }

                return $handler->handle($request);
            case 'Planning':
                $user = $request->getAttribute('currentUser');
                if (!$user->isResponsable() && !$user->isHautResponsable() && !$user->isAdmin()) {
                    return call_user_func(
                        $container->get('forbiddenHandler'),
                        $request,
                        $handler
                    );
                }

                return $handler->handle($request);
            default:
                throw new RuntimeException('Rights were not configured for the route ' . $ressourcePath);
        }
    }
}
