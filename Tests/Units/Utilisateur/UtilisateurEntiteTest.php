<?php declare(strict_types=1);

namespace LibertAPI\Tests\Units\Utilisateur;

use DomainException;
use LibertAPI\Tests\Units\Tools\Libraries\EntiteTestCase;
use LibertAPI\Utilisateur\UtilisateurEntite;
use \LibertAPI\Utilisateur\UtilisateurEntite as _Entite;
use PHPUnit\Framework\Attributes\CoversMethod;

/**
 * Classe de test du modèle de l'utilisateur
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.2
 */
final class UtilisateurEntiteTest extends EntiteTestCase
{
    /**
     * @inheritDoc
     */
    public function testConstructWithId()
    {
        $id = 'Balin';

        $instance = new UtilisateurEntite([
            'id' => $id,
        ]);

        $this->assertConstructWithId($instance, $id);
    }

    /**
     * @inheritDoc
     */
    public function testConstructWithoutId()
    {
        $instance = new UtilisateurEntite([
            'token' => 'token',
        ]);

        $this->assertNull($instance->getId());
    }

    public function testReset()
    {
        $instance = new UtilisateurEntite([
            'id' => 'Balin',
            'token' => 'token',
        ]);

        $this->assertResetWorks($instance);
    }

    public function testPopulateTokenBadDomain()
    {
        $instance = new UtilisateurEntite([]);

        $token = '';

        $this->expectException(DomainException::class);

        $instance->populateToken($token);
    }

    public function testPopulateTokenOk()
    {
        $entite = new UtilisateurEntite([]);

        $token = 'AZP3401GJE9#';

        $entite->populateToken($token);

        $this->assertEquals($token, $entite->getToken());
    }

    public function testUpdateDateLastAccess()
    {
        $entite = new UtilisateurEntite([
            'id' => 3,
            'dateLastAccess' => "0",
        ]);

        $this->assertEquals(0, $entite->getDateLastAccess());

        $entite->updateDateLastAccess();

        $this->assertEquals(date('Y-m-d H:i'), $entite->getDateLastAccess());
    }

    public function testIsPasswordMatchingFalse()
    {
        $password = 'foo';

        $instance = new UtilisateurEntite([
            'id' => 4,
            'password' => password_hash('baz', PASSWORD_DEFAULT),
        ]);

        $this->assertFalse($instance->isPasswordMatching($password));
    }

    public function testIsPasswordMatchingTrue()
    {
        $password = 'foo';

        $instance = new UtilisateurEntite([
            'id' => 4,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $this->assertTrue($instance->isPasswordMatching($password));
    }
}
