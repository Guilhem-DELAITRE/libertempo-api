<?php declare(strict_types = 1);
namespace LibertAPI\Planning\Creneau;

use LibertAPI\Tests\Units\Planning\PlanningRepositoryTest;
use LibertAPI\Tools\Exceptions\MissingArgumentException;
use LibertAPI\Tools\Libraries\AEntite;
use LibertAPI\Tools\Libraries\ARepository;

/**
 * {@inheritDoc}
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 * @see PlanningRepositoryTest
 */
class CreneauRepository extends ARepository
{
    /**
     * @inheritDoc
     */
    public function getOne($id) : AEntite
    {
        throw new \RuntimeException('#' . $id . ' is not a callable resource');
    }

    final protected function getEntiteClass() : string
    {
        return CreneauEntite::class;
    }

    /**
     * @inheritDoc
     */
    final protected function getParamsConsumer2Storage(array $paramsConsumer) : array
    {
        $results = [];
        if (array_key_exists('planningId', $paramsConsumer)) {
            $results['planning_id'] = (int) $paramsConsumer['planningId'];
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    final protected function getStorage2Entite(array $dataStorage)
    {
        return [
            'id' => $dataStorage['creneau_id'],
            'planningId' => $dataStorage['planning_id'],
            'jourId' => $dataStorage['jour_id'],
            'typeSemaine' => $dataStorage['type_semaine'],
            'typePeriode' => $dataStorage['type_periode'],
            'debut' => $dataStorage['debut'],
            'fin' => $dataStorage['fin'],
        ];
    }
    /**
     * Poste une liste de ressource
     *
     * @param array $data Tableau de données à poster
     * @param AEntite $entite [Vide par définition]
     *
     * @return array Tableau d'id des créneaux nouvellement créés
     * @throws MissingArgumentException Si un élément requis n'est pas présent
     * @throws \DomainException Si un élément de la ressource n'est pas dans le bon domaine de définition
     */
    public function postList(array $data) : array
    {
        $postIds = [];
        $this->beginTransaction();
        foreach ($data as $creneau) {
            try {
                $postIds[] = $this->postOne($creneau);
            } catch (\Exception $e) {
                $this->rollback();
                throw $e;
            }
        }
        $this->commit();

        return $postIds;
    }

    /**
     * @inheritDoc
     */
    final protected function getEntite2Storage(AEntite $entite) : array
    {
        return [
            'planning_id' => $entite->getPlanningId(),
            'jour_id' => $entite->getJourId(),
            'type_semaine' => $entite->getTypeSemaine(),
            'type_periode' => $entite->getTypePeriode(),
            'debut' => $entite->getDebut(),
            'fin' => $entite->getFin(),
        ];
    }

    /**
     * @inheritDoc
     */
    final protected function setValues(array $values)
    {
        $this->queryBuilder->setValue('planning_id', (string)$values['planning_id']);
        $this->queryBuilder->setValue('jour_id', (string)$values['jour_id']);
        $this->queryBuilder->setValue('type_semaine', (string)$values['type_semaine']);
        $this->queryBuilder->setValue('type_periode', (string)$values['type_periode']);
        $this->queryBuilder->setValue('debut', (string)$values['debut']);
        $this->queryBuilder->setValue('fin', (string)$values['fin']);
    }

    final protected function setSet(array $parametres)
    {
        if (!empty($parametres['planning_id'])) {
            $this->queryBuilder->set('planning_id', ':planning_id');
            $this->queryBuilder->setParameter('planning_id', $parametres['planning_id']);
        }
        if (!empty($parametres['jour_id'])) {
            $this->queryBuilder->set('jour_id', ':jour_id');
            $this->queryBuilder->setParameter('jour_id', (int) $parametres['jour_id']);
        }
        if (!empty($parametres['type_semaine'])) {
            $this->queryBuilder->set('type_semaine', ':type_semaine');
            $this->queryBuilder->setParameter('type_semaine', $parametres['type_semaine']);
        }
        if (!empty($parametres['type_periode'])) {
            $this->queryBuilder->set('type_periode', ':type_periode');
            $this->queryBuilder->setParameter('type_periode', $parametres['type_periode']);
        }
        if (!empty($parametres['debut'])) {
            $this->queryBuilder->set('debut', ':debut');
            $this->queryBuilder->setParameter('debut', $parametres['debut']);
        }
        if (!empty($parametres['fin'])) {
            $this->queryBuilder->set('fin', ':fin');
            $this->queryBuilder->setParameter('fin', $parametres['fin']);
        }
    }

    /**
     * @inheritDoc
     */
    final protected function setWhere(array $parametres)
    {
        if (array_key_exists('id', $parametres)) {
            $this->queryBuilder->andWhere('creneau_id = :id');
            $this->queryBuilder->setParameter('id', (int) $parametres['id']);
        }
        if (array_key_exists('planning_id', $parametres)) {
            $this->queryBuilder->andWhere('planning_id = :planningId');
            $this->queryBuilder->setParameter('planningId', (int) $parametres['planning_id']);
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteOne(int $id) : int
    {
        throw new \RuntimeException('Action is forbidden');
    }

    /**
     * @inheritDoc
     */
    final protected function getTableName() : string
    {
        return 'planning_creneau';
    }
}
