<?php

namespace App\Tests\Entity;

use App\Api\Exception\BusinessRuleException;
use App\Domain\Constant\Category;
use App\Domain\Entity\Accommodation;
use PHPUnit\Framework\TestCase;

class AccommodationTest extends TestCase
{
    public function testSetEvaluate_ShouldEvaluateWithSuccessful_WhenRatingIsBiggerOrEqualThenZeroAndLesserOsEqualThenFive()
    {
        $rating = 3;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertEquals($rating, $accommodation->getRating());
    }

    public function testSetEvaluate_ShouldNotEvaluateAndThrowException_WhenRatingIsBiggerThenFive()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = 6;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertNull($accommodation->getRating());
    }

    public function testSetEvaluate_ShouldNotEvaluateAndThrowException_WhenRatingIsLesserThenZero()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = -1;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertNull($accommodation->getRating());
    }

    public function testSetCategory_ShouldThrowException_WhenCategorySettedIsNotValid()
    {
        $this->expectException(BusinessRuleException::class);

        $accommodation = new Accommodation();
        $accommodation->setCategory("nonExistentCategory");
        $this->assertNull($accommodation->getCategory());
    }

    public function testSetCategory_ShouldSetCategory_WhenCategorySettedIsValid()
    {
        $category = Category::EXISTENT_CATEGORIES["hotel"];
        $accommodation = new Accommodation();
        $accommodation->setCategory($category);
        $this->assertEquals($category, $accommodation->getCategory());
    }

    public function testSetImage_ShouldThrowException_WhenImageIsNotAValidUrl()
    {
        $this->expectException(BusinessRuleException::class);

        $accommodation = new Accommodation();
        $accommodation->setImage("thisIsNotAnUrl");
        $this->assertNull($accommodation->getImage());
    }

    public function testSetImage_ShouldSetImageUrl_WhenItIsAValidUrl()
    {
        $imageUrl = "http://trivago.com/logo.jpg";
        $accommodation = new Accommodation();
        $accommodation->setImage($imageUrl);
        $this->assertEquals($imageUrl, $accommodation->getImage());
    }

    public function testSetReputation_ShouldSetReputation_WhenReputationIsBiggerOrEqualThenZeroAndLesserOsEqualThenOneThousand()
    {
        $reputation = 500;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
        $this->assertEquals($reputation, $accommodation->getReputation());
    }

    public function testSetReputation_ShouldThrowException_WhenReputationIsBiggerThenOneThousand()
    {
        $this->expectException(BusinessRuleException::class);

        $reputation = 1001;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
        $this->assertNull($accommodation->getReputation());
    }

    public function testSetReputation_ShouldThrowException_WhenReputationIsLesserThenZero()
    {
        $this->expectException(BusinessRuleException::class);

        $reputation = -1;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
        $this->assertNull($accommodation->getReputation());
    }

    public function testGetReputationBadge_ShouldReturnRedColor_WhenReputationIsLesserOrEqualThen500()
    {
        $accommodation = new Accommodation();

        $accommodation->setReputation(500);
        $this->assertEquals("red", $accommodation->getReputationBadge()->__toString());

        $accommodation->setReputation(250);
        $this->assertEquals("red", $accommodation->getReputationBadge()->__toString());
    }

    public function testGetReputationBadge_ShouldReturnYellowColor_WhenReputationIsBiggerThen501AndLesserOrEqualThen799()
    {
        $accommodation = new Accommodation();

        $accommodation->setReputation(501);
        $this->assertEquals("yellow", $accommodation->getReputationBadge()->__toString());

        $accommodation->setReputation(799);
        $this->assertEquals("yellow", $accommodation->getReputationBadge()->__toString());
    }

    public function testGetReputationBadge_ShouldReturnGreenColor_WhenReputationIsBiggerThen799()
    {
        $accommodation = new Accommodation();

        $accommodation->setReputation(800);
        $this->assertEquals("green", $accommodation->getReputationBadge()->__toString());

        $accommodation->setReputation(900);
        $this->assertEquals("green", $accommodation->getReputationBadge()->__toString());
    }

    public function testGetReputationBadge_ShouldThrowException_WhenReputationIsNull()
    {
        $this->expectException(BusinessRuleException::class);
        $accommodation = new Accommodation();
        $this->assertNull($accommodation->getReputationBadge());
    }
}
