<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Solde;

use LibertAPI\Solde\SoldeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;

/**
 * Classe de test du repository du solde
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina <wouldsmina@gmail.com>
 *
 * @since 1.9
 */
final class SoldeRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = SoldeRepository::class;

    final protected function getStorageContent() : array
    {
        return [
            'id' => 'bellamy',
            'su_login' => 'bellamy',
            'su_abs_id' => 2,
            'su_nb_an' => 100,
            'su_solde' => 10.5,
            'su_reliquat' => 1.5,
        ];
    }

    protected function getConsumerContent() : array
    {
        return [
            'login' => 'blake',
            'type_absence' => 2,
        ];
    }
}
