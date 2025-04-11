<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Groupe\GrandResponsable;

use LibertAPI\Groupe\GrandResponsable\GrandResponsableEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de grand responsable de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.1
 */
final class GrandResponsableEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 23;
        $groupeId = 4;
        $login = 'Mortimer';

        $instance = new GrandResponsableEntite(['id' => $id,
            'groupeId' => $groupeId,
            'login' => $login,
        ]);


        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($groupeId, $instance->getGroupeId());
        $this->assertEquals($login, $instance->getLogin());
    }

    public function testConstructWithoutId()
    {
        $instance = new GrandResponsableEntite([
            'groupeId' => 5,
            'login' => 'Black cat',
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
        $instance = new GrandResponsableEntite([
            'id' => 4,
            'groupeId' => 3,
        ]);

        $this->assertResetWorks($instance);
    }
}
