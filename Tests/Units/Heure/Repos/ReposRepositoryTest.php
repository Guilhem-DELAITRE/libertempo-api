<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Heure\Repos;

use LibertAPI\Heure\Repos\ReposRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;

/**
 * Classe de test du repository de l'heure de repos
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.8
 */
final class ReposRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = ReposRepository::class;

    final protected function getStorageContent() : array
    {
        return [
            'id_heure' => 42,
            'login' => 'Sherlock',
            'debut' => 7427,
            'fin' => 4527,
            'duree' => 78,
            'type_periode' => 26,
            'statut' => 3,
            'comment' => 'Arsène',
            'comment_refus' => 'Lupin',
        ];
    }

    protected function getConsumerContent() : array
    {
        return [
            'login' => 'Watson',
            'debut' => 77,
            'fin' => 89432,
        ];
    }
}
