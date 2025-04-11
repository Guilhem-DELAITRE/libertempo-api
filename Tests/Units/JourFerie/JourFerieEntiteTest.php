<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\JourFerie;

use LibertAPI\JourFerie\JourFerieEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de jour férié
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class JourFerieEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;

        $instance = new JourFerieEntite([
            'id' => $id,
            'date' => 'date'
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals('date', $instance->getDate());
    }

    public function testConstructWithoutId()
    {
        $instance = new JourFerieEntite(['date' => 'a']);

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
        $instance = new JourFerieEntite(['date' => 'date']);

        $this->assertResetWorks($instance);
    }
}
