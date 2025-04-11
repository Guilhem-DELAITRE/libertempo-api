<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Heure\Additionnelle;

use LibertAPI\Heure\Additionnelle\AdditionnelleEntite;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;

/**
 * Classe de test de l'entité d'heure de Additionnelle
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.8
 */
final class AdditionnelleEntiteTest extends EntiteTestCase
{
    public function testConstructWithId()
    {
        $id = 58;
        $commentaire = 'Barry Allen';
        $commentaireRefus = 'Barry Allen 2';

        $instance = new AdditionnelleEntite([
            'id' => $id,
            'login' => 'Abagnale',
            'debut' => 1000,
            'fin' => 1100,
            'duree' => 10,
            'type_periode' => 7,
            'statut' => 10,
            'commentaire' => $commentaire,
            'commentaire_refus' => $commentaireRefus,
        ]);

        $this->assertConstructWithId($instance, $id);
        $this->assertEquals('Abagnale', $instance->getLogin());
        $this->assertEquals(1000, $instance->getDebut());
        $this->assertEquals(1100, $instance->getFin());
        $this->assertEquals(10, $instance->getDuree());
        $this->assertEquals(7, $instance->getTypePeriode());
        $this->assertEquals(10, $instance->getStatut());
        $this->assertEquals($commentaire, $instance->getCommentaire());
        $this->assertEquals($commentaireRefus, $instance->getCommentaireRefus());
    }

    public function testConstructWithoutId()
    {
        $instance = new AdditionnelleEntite([
            'login' => 'Abagnale',
            'debut' => 1000,
        ]);

        $this->assertNull($instance->getId());
    }

    public function testReset()
    {
        $instance = new AdditionnelleEntite([
            'login' => 'Abagnale',
            'debut' => 1000,
        ]);

        $this->assertResetWorks($instance);
    }
}
