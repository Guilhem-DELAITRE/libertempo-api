<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Groupe\Responsable;

use LibertAPI\Groupe\Responsable\ResponsableRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository de responsable de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class ResponsableRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = ResponsableRepository::class;

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->getOne(4);
    }

    final protected function getStorageContent() : array
    {
        return [
            'id' => 'Aladdin',
            'gr_gid' => '8',
            'gr_login' => 'Churchill',
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

        $instance->putOne(98, []);
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

        $instance->deleteOne(987);
    }
}
