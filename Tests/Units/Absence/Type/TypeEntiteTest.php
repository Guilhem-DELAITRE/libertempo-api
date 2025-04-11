<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Absence\Type;

use DomainException;
use LibertAPI\Absence\Type\TypeEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de type d'absence
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class TypeEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;
        $type = 'type';
        $libelle = 'douze';

        $instance = new TypeEntite([
            'id' => $id,
            'type' => $type,
            'libelle' => $libelle,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($type, $instance->getType());
        $this->assertEquals($libelle, $instance->getLibelle());
    }

    public function testConstructWithoutId()
    {
        $instance = new TypeEntite([
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $instance = new TypeEntite([]);
        $data = ['type' => '', 'libelle' => '45', 'libelleCourt' => 'non'];

        $this->expectException(DomainException::class);

        $instance->populate($data);
    }

    public function testPopulateOk()
    {
        $instance = new TypeEntite([]);

        $data = ['type' => 'a', 'libelle' => '45', 'libelleCourt' => 'oui'];

        $instance->populate($data);

        $this->assertEquals($data['type'], $instance->getType());
        $this->assertEquals($data['libelle'], $instance->getLibelle());
    }

    public function testReset()
    {
        $instance = new TypeEntite([
            'id' => 3,
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertResetWorks($instance);
    }
}
