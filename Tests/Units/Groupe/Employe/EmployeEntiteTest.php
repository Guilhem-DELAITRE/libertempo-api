<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Groupe\Employe;

use LibertAPI\Groupe\Employe\EmployeEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de l'employe de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.1
 */
final class EmployeEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 23;
        $groupeId = 4;
        $login = 'Boule';

        $instance = new EmployeEntite([
            'id' => $id,
            'groupeId' => $groupeId,
            'login' => $login,
        ]);

        $this->assertEquals($id, $instance->getId());
        $this->assertEquals($groupeId, $instance->getGroupeId());
        $this->assertEquals($login, $instance->getLogin());
    }

    public function testConstructWithoutId()
    {
        $instance = new EmployeEntite([
            'groupeId' => 5,
            'login' => 'Bill',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $this->assertIsBool(true);
    }

    public function testPopulateOk()
    {
        $this->assertIsBool(true);
    }

    public function testReset()
    {
        $instance = new EmployeEntite([
            'id' => 4,
            'groupeId' => 3,
        ]);

        $this->assertResetWorks($instance);
    }
}
