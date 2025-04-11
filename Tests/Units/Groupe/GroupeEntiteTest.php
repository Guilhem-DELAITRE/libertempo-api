<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Groupe;

use DomainException;
use LibertAPI\Groupe\GroupeEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.7
 */
final class GroupeEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;
        $comment = 'this is a comment';

        $instance = new GroupeEntite([
            'id' => $id,
            'name' => 'name',
            'comment' => $comment,
            'double_validation' => true,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals('name', $instance->getName());
        $this->assertEquals($comment, $instance->getComment());
        $this->assertTrue($instance->isDoubleValidated());
    }

    public function testConstructWithoutId()
    {
        $instance = new GroupeEntite([
            'comment' => 'a',
            'double_validation' => true,
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $instance = new GroupeEntite([]);

        $data = ['name' => 'name', 'comment' => '', 'double_validation' => 'N'];

        $this->expectException(DomainException::class);

        $instance->populate($data);
    }

    public function testPopulateOk()
    {
        $instance = new GroupeEntite([]);

        $data = ['name' => 'name', 'comment' => 'k', 'double_validation' => 'N'];

        $instance->populate($data);

        $this->assertEquals('name', $instance->getName());
        $this->assertEquals('k', $instance->getComment());
        $this->assertFalse($instance->isDoubleValidated());
    }

    public function testReset()
    {
        $instance = new GroupeEntite([
            'name' => 'name',
            'comment' => 'k',
            'double_validation' => 'N',
        ]);

        $this->assertResetWorks($instance);
    }
}
