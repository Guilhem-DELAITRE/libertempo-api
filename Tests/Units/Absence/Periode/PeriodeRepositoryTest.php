<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Units\Absence\Periode;

use LibertAPI\Absence\Periode\PeriodeRepository;
use LibertAPI\Tests\Units\Tools\Libraries\RepositoryTestCase;

/**
 * Classe de test du repository des périodes d'absences
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 1.6
 */
final class PeriodeRepositoryTest extends RepositoryTestCase
{
    protected string $testedClass = PeriodeRepository::class;

    public function testPostOne(): void
    {
        $this->assertTrue(true);
    }

    public function testPutOne(): void
    {
        $this->assertTrue(true);
    }

    protected function getStorageContent() : array
    {
        return [
            'p_login' => 'Raphaello',
            'p_date_deb' => '2018-12-24',
            'p_demi_jour_deb' => 'am',
            'p_date_fin' => '2018-12-31',
            'p_demi_jour_fin' => 'pm',
            'p_nb_jours' => '51',
            'p_commentaire' => 'Un grand pouvoir...',
            'p_type' => '1',
            'p_etat' => '',
            'p_edition_id' => 8,
            'p_motif_refus' => '',
            'p_date_demande' => '2018-01-01',
            'p_date_traitement' => '2018-02-25',
            'p_fermeture_id' => 5,
            'p_num' => 12,
        ];
    }

    protected function getConsumerContent() : array
    {
        return [];
    }
}
