<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Controllers;

use LibertAPI\Tools\Interfaces;
use LibertAPI\Tools\Libraries\Controller;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Interfaces\RouteParserInterface;
use \Slim\Interfaces\RouteResolverInterface as IRouter;
use LibertAPI\Groupe\Responsable;
use Doctrine\ORM\EntityManager;

/**
 * Contrôleur de responsable de groupes
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.7
 *
 * Ne devrait être contacté que par le routeur
 * Ne devrait contacter que le ResponsableRepository
 */
final class GroupeResponsableController extends Controller
implements Interfaces\IGetable
{
    public function __construct(Responsable\ResponsableRepository $repository, RouteParserInterface $router, EntityManager $entityManager)
    {
        parent::__construct($repository, $router, $entityManager);
    }

    /**
     * {@inheritDoc}
     */
    public function get(IRequest $request, IResponse $response, array $arguments) : IResponse
    {
        $parameters = array_merge($arguments, $request->getQueryParams());
        try {
            $employes = $this->repository->getList($parameters);
        } catch (\UnexpectedValueException $e) {
            return $this->getResponseNoContent($response);
        } catch (\Exception $e) {
            return $this->getResponseError($response, $e);
        }
        $entites = array_map([$this, 'buildData'], $employes);

        return $this->getResponseSuccess($response, $entites, 200);
    }

    /**
     * Construit le « data » du json
     *
     * @param Responsable\ResponsableEntite $entite Responsable
     *
     * @return array
     */
    private function buildData(Responsable\ResponsableEntite $entite) : array
    {
        return [
            'login' => $entite->getLogin(),
        ];
    }
}
