<?php declare(strict_types = 1);
namespace LibertAPI\Tools\Middlewares;

use Doctrine\ORM\ORMSetup;
use LibertAPI\Tools\AMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Doctrine\DBAL;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Connexion DB
 *
 * @since 1.0
 */
final class DBConnector extends AMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $dbh = ('ci' === $request->getHeaderLine('stage', null))
            ? $this->getTestBase()
            : $this->getRealBase();
        $connexion = DBAL\DriverManager::getConnection(['pdo' => $dbh, 'driver' => 'pdo_mysql']);

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

    private function getTestBase() : \PDO
    {
        $dbh = new \PDO('sqlite:' . TESTS_FUNCTIONALS_PATH . DS . '_data/current.sqlite');
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
        /* Push last access date on the fly */
        $hours = 6 * 3600;
        $newDate = date('Y-m-d H:i', time() + $hours);
        $dbh->query('UPDATE `conges_users` SET date_last_access = "' . $newDate . '"');

        return $dbh;
    }

    private function getRealBase() : \PDO
    {
        $configuration = $this->getContainer()->get('configurationFileData');
        $dbh = new \PDO(
            'mysql:host=' . $configuration->db->serveur . ';dbname=' . $configuration->db->base,
            $configuration->db->utilisateur,
            $configuration->db->mot_de_passe,
            [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\';']
        );

        return $dbh;
    }
}
