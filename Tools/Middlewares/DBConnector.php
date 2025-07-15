<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\ORMSetup;
use LibertAPI\Tools\AMiddleware;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Doctrine\DBAL;
use Doctrine\ORM\EntityManager;

/**
 * Connexion DB
 *
 * @since 1.0
 */
final class DBConnector extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $connexion = ('ci' === $request->getHeaderLine('stage', null))
            ? $this->getTestBase()
            : $this->getRealBase();

        // Create a simple "default" Doctrine ORM configuration for Annotations
        // @TODO: Alter if prod mod
        $isDevMode = true;
        $useSimpleAnnotation = false;
        $paths = [__DIR__ . '/'];
        $configuration = ORMSetup::createAttributeMetadataConfiguration(
            $paths,
            $isDevMode,
        );
        $this->getContainer()->set('storageConnector', $connexion);
        $em = new EntityManager($connexion, $configuration);
        $this->getContainer()->set('entityManager', $em);

        return $handler->handle($request);
    }

    private function getTestBase(): Connection
    {
        $connexion = DBAL\DriverManager::getConnection([
            'driver'=> 'pdo_sqlite',
            'dbname'=> 'main',
            'path' => TESTS_FUNCTIONALS_PATH . DS . '_data/current.sqlite',
        ]);

        $connexion->getNativeConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT

        /* Push last access date on the fly */
        $hours = 6 * 3600;
        $newDate = date('Y-m-d H:i', time() + $hours);
        $connexion->executeQuery('UPDATE `conges_users` SET date_last_access = "' . $newDate . '"');

        return $connexion;
    }

    private function getRealBase() : Connection
    {
        $configuration = $this->getContainer()->get('configurationFileData');

        error_log(print_r($configuration->db, true));

        $connexion = DBAL\DriverManager::getConnection(
            [
                'driver' => 'pdo_mysql',
                'host' => $configuration->db->serveur,
                'dbname' => $configuration->db->base,
                'user' => $configuration->db->utilisateur,
                'password' => $configuration->db->mot_de_passe,
            ],
        );

        $dbh = new \PDO(
            'mysql:host=' . $configuration->db->serveur . ';dbname=' . $configuration->db->base,
            $configuration->db->utilisateur,
            $configuration->db->mot_de_passe,
            [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\';']
        );

        return $connexion;
    }
}
