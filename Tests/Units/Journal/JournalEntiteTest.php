<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Journal;

use LibertAPI\Journal\JournalEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;
use RuntimeException;

/**
 * Classe de test de l'entité journal
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class JournalEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 3;
        $numero = 93;
        $utilisateurActeur = 'tintin';

        $instance = new JournalEntite([
            'id' => $id,
            'numeroPeriode' => $numero,
            'utilisateurActeur' => $utilisateurActeur,
            'utilisateurObjet' => 'milou',
            'etat' => 'haddock',
            'commentaire' => 'moulinsart',
            'date' => '43',
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals($numero, $instance->getNumeroPeriode());
        $this->assertEquals($utilisateurActeur, $instance->getUtilisateurActeur());
        $this->assertEquals('milou', $instance->getUtilisateurObjet());
        $this->assertEquals('haddock', $instance->getEtat());
        $this->assertEquals('moulinsart', $instance->getCommentaire());
        $this->assertEquals('43', $instance->getDate());
    }

    public function testConstructWithoutId()
    {
        $instance = new JournalEntite(['']);

        $this->assertNull($instance->getId());
    }

    public function testPopulate()
    {
        $instance = new JournalEntite([]);

        $this->expectException(RuntimeException::class);

        $instance->populate([]);
    }

    public function testReset()
    {
        $instance = new JournalEntite([
            'id' => 3,
            'name' => 'name',
            'status' => 'status',
        ]);

        $this->assertResetWorks($instance);
    }
}
