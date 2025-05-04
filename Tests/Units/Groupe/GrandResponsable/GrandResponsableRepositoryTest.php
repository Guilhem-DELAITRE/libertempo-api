<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Groupe\GrandResponsable;

use LibertAPI\Groupe\GrandResponsable\GrandResponsableRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository de grand responsable de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class GrandResponsableRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = GrandResponsableRepository::class;

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->getOne(4);
    }

    final protected function getStorageContent() : array
    {
        return [
            'id' => 'Baloo',
            'ggr_gid' => '8',
            'ggr_login' => 'Hurricane',
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

        $instance->putOne(123, []);
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

        $instance->deleteOne(2182);
    }
}
