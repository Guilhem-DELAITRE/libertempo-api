<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Planning\Creneau;

use LibertAPI\Planning\Creneau\CreneauRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;
use RuntimeException;

/**
 * Classe de test du repository de créneau de planning
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 */
final class CreneauRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = CreneauRepository::class;

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->getOne(4);
    }

    public function testPutOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->putOne(4, []);
    }

    final protected function getStorageContent() : array
    {
        return [
            'creneau_id' => 42,
            'planning_id' => 12,
            'jour_id' => 7,
            'type_semaine' => 23,
            'type_periode' => 2,
            'debut' => 63,
            'fin' => 55,
        ];
    }

    protected function getConsumerContent() : array
    {
        return [
            'planningId' => 12,
            'jourId' => 4,
            'typeSemaine' => 54,
            'typePeriode' => 191283,
            'debut' => 921,
            'fin' => 2139123,
        ];
    }

    public function testDeleteOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->expectException(RuntimeException::class);

        $instance->deleteOne(111);
    }
}
