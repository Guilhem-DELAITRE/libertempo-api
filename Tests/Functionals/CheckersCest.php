<?php declare(strict_types = 1);
namespace LibertAPI\Tests\Functionals;

/**
 * Classe de test des vérifications communes
 */
class CheckersCest extends BaseTestCest
{
    public function testUnauthorized(\ApiTester $i)
    {
        $i->unsetHttpHeader('Token');
        $i->sendGET('/groupe');

        $i->seeResponseCodeIs(401);
    }

    public function testBadRequest(\ApiTester $i)
    {
        $i->unsetHttpHeader('Accept');
        $i->sendGET('/groupe');

        $i->seeResponseCodeIs(400);
    }
}
