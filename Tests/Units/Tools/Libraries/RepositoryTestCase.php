<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Libraries;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use LibertAPI\Tests\Units\TestCase;
use LibertAPI\Tools\Libraries\AEntite;
use \LibertAPI\Tools\Exceptions\UnknownResourceException;
use LibertAPI\Tools\Libraries\ARepository;
use UnexpectedValueException;

/**
 * Classe de test des repositories
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.6
 */
abstract class RepositoryTestCase extends TestCase
{
    protected string $testedClass;

    protected ARepository $repository;
    protected Connection $connection;
    protected QueryBuilder $queryBuilder;
    protected Query $query;
    protected Statement $statement;
    protected Result $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock($this->getTestedClass());

        $this->statement = $this->createMock(Statement::class);

        $this->result = $this->createMock(Result::class);

        $this->query = $this->createMock(Query::class);
        $this->query
            ->method('execute')
            ->willReturn($this->result);

        $this->queryBuilder = $this->createMock(QueryBuilder::class);
        $this->queryBuilder
            ->method('executeQuery')
            ->willReturn($this->result);

        $this->connection = $this->createMock(Connection::class);
        $this->connection
            ->expects($this->any())
            ->method('createQueryBuilder')
            ->willReturn($this->queryBuilder);
    }

    protected function getTestedClass() : string
    {
        return $this->testedClass;
    }

    public function testGetOneEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->result
            ->method('fetchAssociative')
            ->willReturn([]);

        $this->expectException(UnknownResourceException::class);

        $instance->getOne(4);
    }

    public function testGetListEmpty()
    {
        $instance = new $this->testedClass($this->connection);

        $this->result
            ->method('fetchAllAssociative')
            ->willReturn([]);

        $this->expectException(UnexpectedValueException::class);

        $instance->getList([]);
    }

    public function testGetListOk()
    {
        $instance = new $this->testedClass($this->connection);

        $this->result
            ->method('fetchAllAssociative')
            ->willReturn([$this->getStorageContent()]);

        $res = $instance->getList([]);

        $this->assertEquals(1, count($res));

        array_walk($res, function ($element) {
            $this->assertInstanceOf(AEntite::class, $element);
        });
    }

    abstract protected function getStorageContent() : array;

    public function testPostOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->queryBuilder
            ->method('executeQuery')
            ->willReturn($this->result);

        $this->connection
            ->method('lastInsertId')
            ->willReturn(9182);

        $this->assertEquals(9182, $instance->postOne($this->getConsumerContent()));
    }

    public function testPutOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->result
            ->method('fetchAssociative')
            ->willReturn($this->getStorageContent());

        $this->assertInstanceOf(AEntite::class, $instance->putOne(55, $this->getConsumerContent()));
    }

    abstract protected function getConsumerContent() : array;

    public function testDeleteOne()
    {
        $instance = new $this->testedClass($this->connection);

        $this->queryBuilder
            ->method('executeQuery')
            ->willReturn($this->result);

        $this->result
            ->method('fetchAssociative')
            ->willReturn($this->getStorageContent());

        $this->result
            ->method('rowCount')
            ->willReturn(123);

        $this->assertEquals(123, $instance->deleteOne(4));
    }
}
