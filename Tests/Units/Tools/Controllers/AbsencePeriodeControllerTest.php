<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Tools\Controllers;

use LibertAPI\Absence\Periode\PeriodeEntite;
use LibertAPI\Absence\Periode\PeriodeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RestControllerTestCase;
use LibertAPI\Tools\Controllers\AbsencePeriodeController;
use Psr\Http\Message\ResponseInterface as IResponse;

/**
 * Classe de test de période d'absence
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.6
 */
final class AbsencePeriodeControllerTest extends RestControllerTestCase
{
    protected string $testedClass = AbsencePeriodeController::class;
    /**
     * {@inheritdoc}
     */
    protected function initRepository()
    {
        $this->repository = $this->createMock(PeriodeRepository::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function initEntite(): void
    {
        $this->entite = new PeriodeEntite([
            'id' => 17845,
            'login' => 'Donatello',
            'date_deb' => '2018-12-25',
            'demi_jour_deb' => 'am',
            'date_fin' => '2018-12-31',
            'demi_jour_fin' => 'pm',
            'nb_jours' => '42',
            'commentaire' => 'Cowabunga',
            'type' => '1',
            'etat' => 'ajout',
            'edition_id' => '88',
            'motif_refus' => 'Shredder',
            'date_demande' => '2018-10-12',
            'date_traitement' => '2018-11-11',
            'fermeture_id' => 4,
            'num' => '75',
        ]);
    }

    protected function getOne() : IResponse
    {
        $this->newTestedInstance();

        return $this->testedInstance->get($this->request, $this->response, ['periodeId' => 99]);
    }

    protected function getList() : IResponse
    {
        return $this->testedInstance->get($this->request, $this->response, []);
    }

    final protected function getEntiteContent() : array
    {
        return [];
    }
}
