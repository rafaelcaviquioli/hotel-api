<?php

namespace App\Tests\Entity;

use Exception;
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
        $this->expectException(Exception::class);

        $rating = 6;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
    }

    public function testSetEvaluate_ShouldNotEvaluateAndThrowException_WhenRatingIsLesserThenZero()
    {
        $this->expectException(Exception::class);

        $rating = -1;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
    }

    public function testSetCategory_ShouldThrowException_WhenCategorySettedIsNotValid()
    {
        $this->expectException(Exception::class);

        $accommodation = new Accommodation();
        $accommodation->setCategory("nonExistentCategory");
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
        $this->expectException(Exception::class);

        $accommodation = new Accommodation();
        $accommodation->setImage("thisIsNotAnUrl");
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
        $this->expectException(Exception::class);

        $reputation = 1001;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
    }

    public function testSetReputation_ShouldThrowException_WhenReputationIsLesserThenZero()
    {
        $this->expectException(Exception::class);

        $reputation = -1;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
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
        $this->expectException(Exception::class);
        $accommodation = new Accommodation();
        $this->assertNull($accommodation->getReputationBadge());
    }

    public function testSetName_ShouldThrowException_WhenHaveForbiddenWordsLikeFree(){
        $this->expectException(Exception::class);
        $accommodation = new Accommodation();
        $accommodation->setName("A great accommodation with free wifi");
    }

    public function testSetName_ShouldThrowException_WhenHaveNotForbiddenWordsLikeOffer(){
        $this->expectException(Exception::class);
        $accommodation = new Accommodation();
        $accommodation->setName("This is a good offer near of the beach");
    }

    public function testSetName_ShouldSetHotelName_WhenHaveNotForbiddenWord(){
        $name = "The sprint tower";
        $accommodation = new Accommodation();
        $accommodation->setName($name);
        $this->assertEquals($name, $accommodation->getName());
    }

    public function testSetName_ShouldThrowException_WhenNameIsNotLongerThan10Characters(){
        $this->expectException(Exception::class);
        $accommodation = new Accommodation();

        $nameWithNineCharacteres = "Hyatt Rege";
        $accommodation->setName($nameWithNineCharacteres);
    }
}
