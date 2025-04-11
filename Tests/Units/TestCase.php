<?php

namespace LibertAPI\Tests\Units;



use LibertAPI\Tools\Libraries\AEntite;

class TestCase extends \PHPUnit\Framework\TestCase
{
    final protected function assertConstructWithId(AEntite $entite, $id): void
    {
        $this->assertEquals($id, $entite->getId());
    }

    final protected function assertReset(AEntite $entite): void
    {
        $entite->reset();

        $this->assertNull($entite->getId());
    }
}