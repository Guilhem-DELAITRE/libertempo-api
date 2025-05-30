<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Controllers;

use LibertAPI\Tools\Libraries\Controller;
use Psr\Http\Message\ServerRequestInterface as IRequest;
use Psr\Http\Message\ResponseInterface as IResponse;
use Slim\Interfaces\RouteParserInterface;
use \Slim\Interfaces\RouteResolverInterface as IRouter;
use LibertAPI\Journal;
use Doctrine\ORM\EntityManager;

/**
 * Contrôleur de journal
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 * @see \LibertAPI\Tests\Units\Journal\JournalController
 */
final class JournalController extends Controller
{
    public function __construct(Journal\JournalRepository $repository, RouteParserInterface $router, EntityManager $entityManager)
    {
        parent::__construct($repository, $router, $entityManager);
    }

     /**
      * {@inheritDoc}
      */
    public function get(IRequest $request, IResponse $response, array $arguments) : IResponse
    {
        unset($arguments);
        try {
            $resources = $this->repository->getList(
                $request->getQueryParams()
            );
        } catch (\UnexpectedValueException $e) {
            return $this->getResponseNoContent($response);
        } catch (\Exception $e) {
            return $this->getResponseError($response, $e);
        }
        $entites = array_map([$this, 'buildData'], $resources);

        return $this->getResponseSuccess($response, $entites, 200);
    }

    /**
     * Construit le « data » du json
     *
     * @param Journal\JournalEntite $entite Journal
     *
     * @return array
     */
    private function buildData(Journal\JournalEntite $entite)
    {
        return [
            'id' => $entite->getId(),
            'numeroPeriode' => $entite->getNumeroPeriode(),
            'utilisateurActeur' => $entite->getUtilisateurActeur(),
            'utilisateurObjet' => $entite->getUtilisateurObjet(),
            'etat' => $entite->getEtat(),
            'commentaire' => $entite->getCommentaire(),
            'date' => $entite->getDate(),
        ];
    }

}
