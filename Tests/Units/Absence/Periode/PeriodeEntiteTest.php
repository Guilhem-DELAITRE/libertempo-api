<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Absence\Periode;

use LibertAPI\Absence\Periode\PeriodeEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;


/**
 * Classe de test de l'entité de période d'absence
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.1
 */
final class PeriodeEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $login = 'Logan';
        $commentaire = 'Je ne suis pas gros !';

        $instance = new PeriodeEntite([
            'id' => $login,
            'login' => $login,
            'commentaire' => $commentaire,
        ]);

        $this->assertConstructWithId($instance, $login);
        $this->assertEquals($login, $instance->getLogin());
        $this->assertEquals($commentaire, $instance->getCommentaire());
    }

    public function testConstructWithoutId()
    {
        $instance = new PeriodeEntite([
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testPopulateBadDomain()
    {
        $instance = new PeriodeEntite([]);

        $data = ['login' => ''];

        $this->expectException(\DomainException::class);

        $instance->populate($data);
    }

    public function testPopulateOk()
    {
        $instance = new PeriodeEntite([]);
        $data = ['login' => 'Logan'];

        $instance->populate($data);

        $this->assertEquals($data['login'], $instance->getLogin());
    }

    public function testReset()
    {
        $instance = new PeriodeEntite([
            'id' => 3,
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertResetWorks($instance);
    }
}
