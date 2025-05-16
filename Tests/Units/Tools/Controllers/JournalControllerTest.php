<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use Exception;
use LibertAPI\Journal\JournalEntite;
use LibertAPI\Journal\JournalRepository;
use LibertAPI\Tests\Units\Tools\Libraries\ControllerTestCase;
use LibertAPI\Tools\Controllers\JournalController;
use LibertAPI\Utilisateur\UtilisateurEntite;
use UnexpectedValueException;

/**
 * Classe de test du contrôleur de journal
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.5
 */
final class JournalControllerTest extends ControllerTestCase
{
    protected string $testedClass = JournalController::class;

    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(JournalRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite()
    {
        $this->entite = new JournalEntite([
            'id' => 42,
            'numeroPeriode' => 88,
            'utilisateurActeur' => '4',
            'utilisateurObjet' => '8',
            'etat' => 'cassé',
            'commentaire' => 'c\'est cassé',
            'date' => 'now',
        ]);
    }

    /*************************************************
     * GET
     *************************************************/

    /**
     * Teste la méthode get d'une liste trouvée
     */
    public function testGetFound()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturn([$this->entite]);

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);

        $data = $this->getJsonDecoded($response->getBody());

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(200, $data['code']);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('OK', $data['message']);
        $this->assertCount(1, $data['data']);
        $this->arrayHasKey('id', $data['data'][0]);
    }

    /**
     * Teste la méthode get d'une liste non trouvée
     */
    public function testGetNotFound()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new UnexpectedValueException(''));

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);

        $this->assertSuccessEmpty($response);
    }

    /**
     * Teste le fallback de la méthode get d'une liste
     */
    public function testGetFallback()
    {
        $this->request
            ->method('getQueryParams')
            ->willReturn([]);

        $this->repository
            ->method('getList')
            ->willReturnCallback(fn () => throw new Exception('e'));

        $this->newTestedInstance();

        $response = $this->testedInstance->get($this->request, $this->response, []);

        $this->assertError($response);
    }
}
