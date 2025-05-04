<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Groupe\Employe;

use LibertAPI\Groupe\Employe\EmployeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository d'employé de groupe
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.0
 */
final class EmployeRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = EmployeRepository::class;

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
            'gu_gid' => '8',
            'gu_login' => 'Teddy',
        ];
    }

    public function testPostOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->postOne($this->getStorageContent());
    }

    public function testPutOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->putOne(1, []);
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

        $instance->deleteOne(91823);
    }
}
