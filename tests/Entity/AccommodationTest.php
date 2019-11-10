<?php

namespace App\Tests\Entity;

use App\Api\Exception\BusinessRuleException;
use App\Domain\Entity\Accommodation;
use PHPUnit\Framework\TestCase;

class AccommodationTest extends TestCase
{
    public function testEvaluate_shouldEvaluateWithSuccessful_WhenRatingIsBiggerOrEqualThenZeroAndLesserOsEqualThenFive()
    {
        $rating = 3;
        $accommodation = new Accommodation();
        $accommodation->evaluate($rating);
        $this->assertEquals($rating, $accommodation->getRating());
    }
    public function testEvaluate_shouldNotEvaluateAndThrowException_WhenRatingIsBiggerThenFive()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = 6;
        $accommodation = new Accommodation();
        $accommodation->evaluate($rating);
        $this->assertNull($accommodation->getRating());
    }
    public function testEvaluate_shouldNotEvaluateAndThrowException_WhenRatingIsLesserThenZero()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = -1;
        $accommodation = new Accommodation();
        $accommodation->evaluate($rating);
        $this->assertNull($accommodation->getRating());
    }
}