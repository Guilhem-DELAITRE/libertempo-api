<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Absence\Type;

use LibertAPI\Absence\Type\TypeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;

/**
 * Classe de test du repository de planning
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class TypeRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = TypeRepository::class;

    protected function getStorageContent() : array
    {
        return [
            'ta_id' => 38,
            'ta_type' => 81,
            'ta_libelle' => 'libelle',
            'ta_short_libelle' => 'li',
            'type_natif' => 1,
            'ta_actif' => 1,
        ];
    }

    protected function getConsumerContent() : array
    {
        return [
            'type' => '1',
            'libelle' => 'Romeo',
            'libelleCourt' => 'Juliette',
            // TODO 2018-07-30 : puisqu'on ne peut pas demander à l'utilisateur de choisir
            // s'il veut un type natif ou non (ça n'a pas de sens)
            // l'application doit le deviner toute seule (critères ?)
            //'typeNatif' => 1,
        ];
    }
}
