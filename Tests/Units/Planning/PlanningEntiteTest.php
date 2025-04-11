<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Planning;

use DomainException;
use LibertAPI\Planning\PlanningEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test du modèle de planning
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
final class PlanningEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;
        $name = 'name';
        $status = 4;

        $instance = new PlanningEntite([
            'id' => $id,
            'name' => $name,
            'status' => $status,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($name, $instance->getName());
        $this->assertEquals($status, $instance->getStatus());
    }

    public function testConstructWithoutId()
    {
        $instance = new PlanningEntite([
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $instance = new PlanningEntite([]);

        $data = [
            'name' => '',
            'status' => 45,
        ];

        $this->expectException(DomainException::class);

        $instance->populate($data);
    }

    public function testPopulateOk()
    {
        $instance = new PlanningEntite([]);

        $data = [
            'name' => 'test',
            'status' => 48,
            ];

        $instance->populate($data);

        $this->assertEquals($data['name'], $instance->getName());
        $this->assertEquals($data['status'], $instance->getStatus());
    }

    public function testReset()
    {
        $instance = new PlanningEntite([
            'id' => 3,
            'name' => 'name',
            'status' => 'status',
            ]);

        $this->assertResetWorks($instance);
    }
}
