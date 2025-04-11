<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Groupe\Responsable;

use LibertAPI\Groupe\Responsable\ResponsableEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de responsable de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.1
 */
final class ResponsableEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 23;
        $groupeId = 4;
        $login = 'Sherlock';

        $instance = new ResponsableEntite([
            'id' => $id,
            'groupeId' => $groupeId,
            'login' => $login,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($groupeId, $instance->getGroupeId());
        $this->assertEquals($login, $instance->getLogin());
    }

    public function testConstructWithoutId()
    {
        $instance = new ResponsableEntite([
            'groupeId' => 5,
            'login' => 'Watson',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $this->assertTrue(true);
    }

    public function testPopulateOk()
    {
        $this->assertTrue(true);
    }

    public function testReset()
    {
        $instance = new ResponsableEntite([
            'id' => 4,
            'groupeId' => 3,
        ]);

        $this->assertResetWorks($instance);
    }
}
