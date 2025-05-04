<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\JourFerie;

use LibertAPI\JourFerie\JourFerieRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository de jour férié
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class JourFerieRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = JourFerieRepository::class;

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->getOne(4);
    }

    final protected function getStorageContent() : array
    {
        return [
            'id' => uniqid(),
            'jf_date' => '2018-05-14',
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

        $instance->putOne(81273, []);
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

        $instance->deleteOne(518);
    }
}
