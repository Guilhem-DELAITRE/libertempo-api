<?php declare(strict_types = 1);
namespace LibertAPI\Heure\Repos;

use LibertAPI\Tools\Libraries\AEntite;

/**
 * {@inheritDoc}
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.8
 * @see \LibertAPI\Tests\Units\Heure\Repos\ReposRepositoryTest
 *
 * Ne devrait être contacté que par le HeureReposEmployeController
 * Ne devrait contacter que le ReposEntite
 */
class ReposRepository extends \LibertAPI\Tools\Libraries\ARepository
{
    final protected function getEntiteClass() : string
    {
        return ReposEntite::class;
    }

    /**
     * @inheritDoc
     */
    final protected function getParamsConsumer2Storage(array $paramsConsumer) : array
    {
        $results = [];
        if (array_key_exists('login', $paramsConsumer)) {
            $results['login'] = (string) $paramsConsumer['login'];
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    final protected function getStorage2Entite(array $dataStorage)
    {
        return [
            'id' => $dataStorage['id_heure'],
            'login' => $dataStorage['login'],
            'debut' => (int) $dataStorage['debut'],
            'fin' => (int) $dataStorage['fin'],
            'duree' => (int) $dataStorage['duree'],
            'type_periode' => (int) $dataStorage['type_periode'],
            'statut' => (int) $dataStorage['statut'],
            'commentaire' => $dataStorage['comment'],
            'commentaire_refus' => $dataStorage['comment_refus'],
        ];
    }

    /**
     * @inheritDoc
     */
    final protected function setValues(array $values)
    {
        unset($values);
    }

    final protected function setSet(array $parametres)
    {
        unset($parametres);
    }

    /**
     * @inheritDoc
     */
    final protected function setWhere(array $parametres)
    {
        if (array_key_exists('login', $parametres)) {
            $this->queryBuilder->andWhere('login = :login');
            $this->queryBuilder->setParameter('login', $parametres['login']);
        }
    }

    /**
     * @inheritDoc
     */
    final protected function getEntite2Storage(AEntite $entite) : array
    {
        unset($entite);
        return [];
    }

    /**
     * @inheritDoc
     */
    final protected function getTableName() : string
    {
        return 'heure_repos';
    }
}
