<?php declare(strict_types = 1);
namespace LibertAPI\Planning\Creneau;

use LibertAPI\Tools\Exceptions\MissingArgumentException;

/**
 * {@inheritDoc}
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 * @see \LibertAPI\Tests\Units\Planning\PlanningEntiteTest
 *
 * Ne devrait être contacté que par le CreneauRepository
 * Ne devrait contacter personne
 */
class CreneauEntite extends \LibertAPI\Tools\Libraries\AEntite
{
    /**
     * Retourne la donnée la plus à jour du champ planning id
     *
     * @return int
     */
    public function getPlanningId()
    {
        return (int) $this->getFreshData('planningId');
    }

    /**
     * Retourne la donnée la plus à jour du champ jour id
     *
     * @return int
     */
    public function getJourId()
    {
        return (int) $this->getFreshData('jourId');
    }

    /**
     * Retourne la donnée la plus à jour du champ type semaine
     *
     * @return int
     */
    public function getTypeSemaine()
    {
        return (int) $this->getFreshData('typeSemaine');
    }

    /**
     * Retourne la donnée la plus à jour du champ type periode
     *
     * @return int
     */
    public function getTypePeriode()
    {
        return (int) $this->getFreshData('typePeriode');
    }

    /**
     * Retourne la donnée la plus à jour du champ debut
     *
     * @return int
     */
    public function getDebut()
    {
        return (int) $this->getFreshData('debut');
    }

    /**
     * Retourne la donnée la plus à jour du champ fin
     *
     * @return int
     */
    public function getFin()
    {
        return (int) $this->getFreshData('fin');
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data)
    {
        if (!$this->hasAllRequired($data)) {
            throw new MissingArgumentException('');
        }
        $this->setPlanningId($data['planningId']);
        $this->setJourId($data['jourId']);
        $this->setTypeSemaine($data['typeSemaine']);
        $this->setTypePeriode($data['typePeriode']);
        $this->setDebut($data['debut']);
        $this->setFin($data['fin']);

        $erreurs = $this->getErreurs();
        if (!empty($erreurs)) {
            throw new \DomainException(json_encode($erreurs));
        }
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

    private function setPlanningId($planningId)
    {
        // domaine de planning id ?
        if (empty($planningId)) {
            $this->setErreur('planningId', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['planningId'] = $planningId;
    }

    private function setJourId($jourId)
    {
        // domaine de jour id ?
        if (empty($jourId)) {
            $this->setErreur('jourId', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['jourId'] = $jourId;
    }

    private function setTypeSemaine($typeSemaine)
    {
        // domaine de type semaine ?
        if (false) {
            $this->setErreur('typeSemaine', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['typeSemaine'] = $typeSemaine;
    }

    private function setTypePeriode($typePeriode)
    {
        // domaine de type période ?
        if (empty($typePeriode)) {
            $this->setErreur('typePeriode', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['typePeriode'] = $typePeriode;
    }

    private function setDebut($debut)
    {
        // domaine de debut ?
        if (empty($debut)) {
            $this->setErreur('debut', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['debut'] = $debut;
    }

    private function setFin($fin)
    {
        // domaine de fin ?
        if (empty($fin)) {
            $this->setErreur('fin', 'Le champ est vide');
            return;
        }

        $this->dataUpdated['fin'] = $fin;
    }
}
