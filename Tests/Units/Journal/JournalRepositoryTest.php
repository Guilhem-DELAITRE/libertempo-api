<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Journal;

use LibertAPI\Journal\JournalRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository de journal
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class JournalRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = JournalRepository::class;

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->getOne(4);
    }

    final protected function getStorageContent() : array
    {
        return [
            'log_id' => 81,
            'log_p_num' => 1213,
            'log_user_login_par' => 'Baloo',
            'log_user_login_pour' => 'Mowgli',
            'log_etat' => 'gere',
            'log_comment' => 'nope',
            'log_date' => '2017-12-01',
        ];
    }

    public function testPostOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->postOne($this->getConsumerContent());
    }

    public function testPutOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->putOne(8712, []);
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

        $instance->deleteOne(723);
    }
}
