<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Planning\Creneau;

use DomainException;
use LibertAPI\Planning\Creneau\CreneauEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de créneau
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
final class CreneauEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;
        $planning = 12;

        $instance = new CreneauEntite([
            'id' => $id,
            'planningId' => $planning,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($planning, $instance->getPlanningId());
    }

    public function testConstructWithoutId()
    {
        $instance = new CreneauEntite([
            'planningId' => 34,
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $instance = new CreneauEntite([]);

        $data = [
            'planningId' => '',
            'typeSemaine' => '',
            'typePeriode' => '',
            'jourId' => '',
            'debut' => '',
            'fin' => ''
        ];

        $this->expectException(DomainException::class);

        $instance->populate($data);
    }

    public function testPopulateOk()
    {
        $instance = new CreneauEntite([]);

        $data = [
            'planningId' => 12,
            'typeSemaine' => 23,
            'typePeriode' => 34,
            'jourId' => 45,
            'debut' => 56,
            'fin' => 67,
        ];

        $instance->populate($data);

        $this->assertEquals($data['planningId'], $instance->getPlanningId());
        $this->assertEquals($data['typeSemaine'], $instance->getTypeSemaine());
        $this->assertEquals($data['typePeriode'], $instance->getTypePeriode());
        $this->assertEquals($data['jourId'], $instance->getJourId());
        $this->assertEquals($data['debut'], $instance->getDebut());
        $this->assertEquals($data['fin'], $instance->getFin());
    }

    public function testReset()
    {
        $instance = new CreneauEntite([
            'id' => 39,
            'planningId' => 'test',
        ]);

        $this->assertResetWorks($instance);
    }
}
