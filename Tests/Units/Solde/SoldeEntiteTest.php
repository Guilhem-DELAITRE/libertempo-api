<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Solde;

use LibertAPI\Solde\SoldeEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité de solde
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina <wouldsmina@gmail.com>
 *
 * @since 1.9
 */
final class SoldeEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 'octavia';

        $instance = new SoldeEntite([
            'id' => $id,
            ]);

        $this->assertConstructWithId($instance, $id);
    }

    public function testConstructWithoutId()
    {
        $instance = new SoldeEntite([
            'type_absence' => 1,
            'solde_annuel' => 100,
            'solde' => 10.5,
            'reliquat' => 7.5,
        ]);

        $this->assertNull($instance->getId());
    }

    public function testReset()
    {
        $instance = new SoldeEntite([
            'login' => 'octavia',
            'type_absence' => 1,
            ]);

        $this->assertResetWorks($instance);
    }
}
