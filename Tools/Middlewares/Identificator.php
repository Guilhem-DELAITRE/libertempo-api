<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use \LibertAPI\Tools\Libraries\AEntite;
use \LibertAPI\Tools\Libraries\ARepository;
use \LibertAPI\Tools\Helpers\Formatter;
use \LibertAPI\Utilisateur;

/**
 * Réalise l'identification. En profite pour pinger.
 *
 * @since 1.0
 */
final class Identificator extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $container = $this->getContainer();
        $repoUtilisateur = $container->get(Utilisateur\UtilisateurRepository::class);
        $openedRoutes = ['Authentification', 'HelloWorld'];
        $ressourcePath = $request->getAttribute('nomRessources');
        if (in_array($ressourcePath, $openedRoutes, true)) {
            return $handler->handle($request);
        } elseif ($this->isIdentificationOK($request, $repoUtilisateur)) {
             // Ping de last_access
            $utilisateur = $repoUtilisateur->updateDateLastAccess($this->utilisateur);
            $request = $request->withAttribute('currentUser', $utilisateur);

            return $handler->handle($request);
        }

        return call_user_func(
            $container->get('unauthorizedHandler'),
            $request,
            $handler
        );
    }

    private function isIdentificationOK(ServerRequestInterface $request, ARepository $repository) : bool
    {
        $token = $request->getHeaderLine('Token');
        if (empty($token)) {
            return false;
        }
        try {
            $this->utilisateur = $repository->find([
                'token' => $token,
                'gt_date_last_access' => $this->getDateLastAccessAuthorized(),
                'isActif' => true,
            ]);
            return $this->utilisateur instanceof AEntite;
        } catch (\UnexpectedValueException $e) {
            return false;
        }
    }

    /**
     * Retourne la date limite de dernier accès pour être considéré en ligne
     *
     * @return string
     */
    private function getDateLastAccessAuthorized() : string
    {
        return Formatter::timeToSQLDatetime(time() - static::DUREE_SESSION);
    }

    /**
     * @var AEntite | null
     */
    private $utilisateur;

    /**
     * @var int Durée de validité du token fourni, en secondes
     */
    const DUREE_SESSION = 30*60;
}
