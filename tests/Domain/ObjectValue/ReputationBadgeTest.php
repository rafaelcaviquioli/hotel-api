<?php

namespace App\Tests\Domain\ObjectValue;

use App\Domain\ObjectValue\ReputationBadge;
use Exception;
use PHPUnit\Framework\TestCase;

class ReputationBadgeTest extends TestCase
{
    public function test__toStringBadge_ShouldReturnRedColor_WhenReputationIsLesserOrEqualThen500()
    {
        $reputationBadge500 = new ReputationBadge(500);
        $this->assertEquals("red", $reputationBadge500->__toString());

        $reputationBadge250 = new ReputationBadge(250);
        $this->assertEquals("red", $reputationBadge250->__toString());
    }

    public function test__toStringBadge_ShouldReturnYellowColor_WhenReputationIsBiggerThen501AndLesserOrEqualThen799()
    {
        $reputationBadge501 = new ReputationBadge(501);
        $this->assertEquals("yellow", $reputationBadge501->__toString());

        $reputationBadge799 = new ReputationBadge(799);
        $this->assertEquals("yellow", $reputationBadge799->__toString());
    }

    public function test__toStringBadge_ShouldReturnGreenColor_WhenReputationIsBiggerThen799()
    {
        $reputationBadge800 = new ReputationBadge(800);
        $this->assertEquals("green", $reputationBadge800->__toString());

        $reputationBadge900 = new ReputationBadge(900);
        $this->assertEquals("green", $reputationBadge900->__toString());
    }
}