<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Tools\Libraries;

use LibertAPI\Tools\Libraries\AEntite;
use PHPUnit\Framework\TestCase;

/**
 * Classe commune de test sur les entités
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
abstract class EntiteTestCase extends TestCase
{
    /**
     * Teste la méthode __construct avec un Id (typiquement lors d'un get())
     */
    abstract public function testConstructWithId();

    /**
     * Teste la méthode __construct sans Id (typiquement lors d'un post())
     */
    abstract public function testConstructWithoutId();

    /**
     * Teste la méthode reset
     */
    abstract public function testReset();

    final protected function assertConstructWithId(AEntite $entite, $id): void
    {
        $this->assertEquals($id, $entite->getId());
    }

    final protected function assertResetWorks(AEntite $entite): void
    {
        $entite->reset();

        $this->assertNull($entite->getId());
    }
}
