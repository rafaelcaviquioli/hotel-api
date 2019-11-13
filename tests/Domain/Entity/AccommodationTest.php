<?php

namespace App\Tests\Domain\Entity;

use App\CrossCutting\Exception\ValidationEntityException;
use Exception;
use App\Domain\Entity\Accommodation;
use App\Domain\ObjectValue\ReputationBadge;
use App\Tests\Helper\Mother\AccommodationMother;
use PHPUnit\Framework\TestCase;

class AccommodationTest extends TestCase
{
    public function testsetRating_ShouldEvaluateWithSuccessful_WhenRatingIsBiggerOrEqualThenZeroAndLesserOsEqualThenFive()
    {
        $rating = 3;
        $accommodation = new Accommodation();
        $accommodation->setRating($rating);
        $this->assertEquals($rating, $accommodation->getRating());
    }

    public function testsetRating_ShouldNotEvaluateAndThrowException_WhenRatingIsBiggerThenFive()
    {
        $this->expectException(ValidationEntityException::class);

        $rating = 6;
        $accommodation = new Accommodation();
        $accommodation->setRating($rating);
    }

    public function testsetRating_ShouldNotEvaluateAndThrowException_WhenRatingIsLesserThenZero()
    {
        $this->expectException(ValidationEntityException::class);

        $rating = -1;
        $accommodation = new Accommodation();
        $accommodation->setRating($rating);
    }

    public function testSetCategory_ShouldThrowException_WhenCategorySettedIsNotValid()
    {
        $this->expectException(ValidationEntityException::class);

        $accommodation = new Accommodation();
        $accommodation->setCategory("nonExistentCategory");
    }

    public function testSetCategory_ShouldSetCategory_WhenCategorySettedIsValid()
    {
        $category = "hotel";
        $accommodation = new Accommodation();
        $accommodation->setCategory($category);
        $this->assertEquals($category, $accommodation->getCategory());
    }

    public function testSetImage_ShouldThrowException_WhenImageIsNotAValidUrl()
    {
        $this->expectException(ValidationEntityException::class);

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
        $this->expectException(ValidationEntityException::class);

        $reputation = 1001;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
    }

    public function testSetReputation_ShouldThrowException_WhenReputationIsLesserThenZero()
    {
        $this->expectException(ValidationEntityException::class);

        $reputation = -1;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);
    }

    public function  testGetReputationBadge_ShouldReturnAReputationBadge_WhenReputationHasAValidValue()
    {
        $reputation = 3;
        $accommodation = new Accommodation();
        $accommodation->setReputation($reputation);

        $this->assertInstanceOf(ReputationBadge::class, $accommodation->getReputationBadge());
    }

    public function testGetReputationBadge_ShouldThrowException_WhenReputationIsNull()
    {
        $this->expectException(ValidationEntityException::class);
        $accommodation = new Accommodation();
        $this->assertNull($accommodation->getReputationBadge());
    }

    public function testSetName_ShouldThrowException_WhenHaveForbiddenWordsLikeFree(){
        $this->expectException(ValidationEntityException::class);
        $accommodation = new Accommodation();
        $accommodation->setName("A great accommodation with free wifi");
    }

    public function testSetName_ShouldThrowException_WhenHaveNotForbiddenWordsLikeOffer(){
        $this->expectException(ValidationEntityException::class);
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
        $this->expectException(ValidationEntityException::class);
        $accommodation = new Accommodation();

        $nameWithNineCharacteres = "Hyatt Rege";
        $accommodation->setName($nameWithNineCharacteres);
    }

    public function testBook_ShouldReduceTheAccommodationAvailability_WhenThereIsAvailability()
    {
        $accommodation = AccommodationMother::getAvailableAccommodation(3);

        $accommodation->book();
        $this->assertEquals(2, $accommodation->getAvailability());

        $accommodation->book();
        $this->assertEquals(1, $accommodation->getAvailability());

        $accommodation->book();
        $this->assertEquals(0, $accommodation->getAvailability());
    }

    public function testBook_ShouldThrowValidationException_WhenThereIsNoAvailability()
    {
        $this->expectException(ValidationEntityException::class);

        $accommodation = AccommodationMother::getUnavailableAccommodation();
        $accommodation->book();
    }
}
