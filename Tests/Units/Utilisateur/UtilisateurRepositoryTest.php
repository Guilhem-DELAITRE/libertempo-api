<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Utilisateur;

use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use LibertAPI\Tools\Libraries\AEntite;
use LibertAPI\Utilisateur\UtilisateurRepository;
use RuntimeException;

/**
 * Classe de test du repository de l'utilisateur
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.2
 */
final class UtilisateurRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = UtilisateurRepository::class;

    public function testFindOk()
    {
        $instance = new $this->testedClass($this->connection);

        $this->result
            ->method('fetchAllAssociative')
            ->willReturn([$this->getStorageContent()]);

        $this->assertEquals('Aladdin', $instance->find([])->getId());
    }

    final protected function getStorageContent() : array
    {
        return [
            'id' => 'Aladdin',
            'token' => 'token',
            'date_last_access' => 'date_last_access',
            'u_login' => 'Aladdin',
            'u_prenom' => 'Aladdin',
            'u_nom' => 'Genie',
            'u_is_resp' => 'Y',
            'u_is_admin' => 'Y',
            'u_is_hr' => 'N',
            'u_is_active' => 'Y',
            'u_passwd' => 'Sésame Ouvre toi',
            'u_quotite' => '21220',
            'u_email' => 'aladdin@example.org',
            'u_num_exercice' => '3',
            'planning_id' => 12,
            'u_heure_solde' => 1,
            'date_inscription' => 123456789,
        ];
    }

    public function testPostOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->postOne($this->getConsumerContent());
    }

    protected function getConsumerContent() : array
    {
        return [
        ];
    }

    public function testDeleteOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->deleteOne(345);
    }
}
