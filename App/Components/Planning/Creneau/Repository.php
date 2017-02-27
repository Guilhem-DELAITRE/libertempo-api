<?php
namespace Api\App\Components\Planning\Creneau;

use Api\App\Exceptions\MissingArgumentException;
use Api\App\Libraries\AModel;

/**
 * {@inheritDoc}
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 * @see \Api\Tests\Units\App\Components\Planning\Repository
 *
 * Ne devrait être contacté que par le Planning\Creneau\Controller, Planning\Repository
 * Ne devrait contacter que le Planning\Creneau\Model, Planning\Creneau\Dao
 */
class Repository extends \Api\App\Libraries\ARepository
{
    /*************************************************
     * GET
     *************************************************/

    /**
     * @inheritDoc
     *
     * @param int $planningId Contrainte de recherche sur le planning
     */
    public function getOne($id, $planningId = -1)
    {
        $id = (int) $id;
        $data = $this->dao->getById($id, $planningId);
        if (empty($data)) {
            throw new \DomainException('Creneau#' . $id . ' is not a valid resource');
        }

        return new Model($this->getDataDao2Model($data));
    }

    /**
     * @inheritDoc
     */
    public function getList(array $parametres)
    {
        /* retourner une collection pour avoir le total, hors limite forcée (utile pour la pagination) */
        $data = $this->dao->getList($this->getParamsConsumer2Dao($parametres));
        if (empty($data)) {
            throw new \UnexpectedValueException('No resource match with these parameters');
        }

        $models = [];
        foreach ($data as $value) {
            $model = new Model($this->getDataDao2Model($value));
            $models[$model->getId()] = $model;
        }

        return $models;
    }

    /**
     * Effectue le mapping des éléments venant de la DAO pour qu'ils soient compréhensibles pour le Modèle
     *
     * @param array $dataDao
     *
     * @return array
     */
    private function getDataDao2Model(array $dataDao)
    {
        return [
            'id' => $dataDao['creneau_id'],
            'planningId' => $dataDao['planning_id'],
            'jourId' => $dataDao['jour_id'],
            'typeSemaine' => $dataDao['type_semaine'],
            'typePeriode' => $dataDao['type_periode'],
            'debut' => $dataDao['debut'],
            'fin' => $dataDao['fin'],
        ];
    }

    /**
     * Effectue le mapping des recherches du consommateur de l'API pour qu'elles
     * soient traitables par la DAO
     *
     * Essentiel pour séparer / traduire les contextes Client / DAO
     *
     * @param array $paramsConsumer Paramètres reçus
     *
     * @return array
     */
    private function getParamsConsumer2Dao(array $paramsConsumer)
    {
        $filterInt = function ($var) {
            return filter_var(
                $var,
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 1]]
            );
        };
        $results = [];
        if (!empty($paramsConsumer['planningId'])) {
            $results['planning_id'] = $filterInt($paramsConsumer['planningId']);
        }

        return $results;
    }

    /*************************************************
     * POST
     *************************************************/

    /**
     * Poste une liste de ressource
     *
     * @param array $data Tableau de données à poster
     * @param AModel $model [Vide par définition]
     *
     * @return array Tableau d'id des créneaux nouvellement créés
     * @throws MissingArgumentException Si un élément requis n'est pas présent
     * @throws \DomainException Si un élément de la ressource n'est pas dans le bon domaine de définition
     */
    public function postList(array $data, AModel $model)
    {
        $postIds = [];
        $this->dao->beginTransaction();
        foreach ($data as $creneau) {
            try {
                $postIds[] = $this->postOne($creneau, $model);
                /*
                 * Le plus cool aurait été de cloner l'objet de base,
                 * mais le clonage de mock est nul, donc on reset pour la boucle
                 */
                $model->reset();
            } catch (\Exception $e) {
                $this->dao->rollback();
                throw $e;
            }
        }
        $this->dao->commit();

        return $postIds;
    }

    /**
     * @inheritDoc
     */
    public function postOne(array $data, AModel $model)
    {
        if (!$this->hasAllRequired($data)) {
            throw new MissingArgumentException('');
        }

        try {
            $model->populate($data);
            $dataDao = $this->getModel2DataDao($model);

            return $this->dao->post($dataDao);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Effectue le mapping des éléments venant du modèle pour qu'ils soient compréhensibles pour la DAO
     *
     * @param Model $model
     *
     * @return array
     */
    private function getModel2DataDao(AModel $model)
    {
        return [
            'planning_id' => $model->getPlanningId(),
            'jour_id' => $model->getJourId(),
            'type_semaine' => $model->getTypeSemaine(),
            'type_periode' => $model->getTypePeriode(),
            'debut' => $model->getDebut(),
            'fin' => $model->getFin(),
        ];
    }

    /**
     * Vérifie que les données passées possèdent bien tous les champs requis
     *
     * @param array $data
     *
     * @return bool
     */
    private function hasAllRequired(array $data)
    {
        foreach ($this->getListRequired() as $value) {
            if (!isset($data[$value])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retourne la liste des champs requis
     *
     * @return array
     */
    private function getListRequired()
    {
        return ['planningId', 'jourId', 'typeSemaine', 'typePeriode', 'debut', 'fin'];
    }

    /*************************************************
     * PUT
     *************************************************/

    /**
     * @inheritDoc
     */
    public function putOne(array $data, AModel $model)
    {
        if (!$this->hasAllRequired($data)) {
            throw new MissingArgumentException('');
        }

        try {
            $model->populate($data);
            $dataDao = $this->getModel2DataDao($model);

            return $this->dao->put($dataDao, $model->getId());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /*************************************************
     * DELETE
     *************************************************/

    /**
     * @inheritDoc
     */
    public function deleteOne(AModel $model)
    {
    }
}
