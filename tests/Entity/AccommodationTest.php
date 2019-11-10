<?php

namespace App\Tests\Entity;

use App\Api\Exception\BusinessRuleException;
use App\Domain\Constant\Category;
use App\Domain\Entity\Accommodation;
use PHPUnit\Framework\TestCase;

class AccommodationTest extends TestCase
{
    public function testSetEvaluate_shouldEvaluateWithSuccessful_WhenRatingIsBiggerOrEqualThenZeroAndLesserOsEqualThenFive()
    {
        $rating = 3;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertEquals($rating, $accommodation->getRating());
    }

    public function testSetEvaluate_shouldNotEvaluateAndThrowException_WhenRatingIsBiggerThenFive()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = 6;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertNull($accommodation->getRating());
    }

    public function testSetEvaluate_shouldNotEvaluateAndThrowException_WhenRatingIsLesserThenZero()
    {
        $this->expectException(BusinessRuleException::class);

        $rating = -1;
        $accommodation = new Accommodation();
        $accommodation->setEvaluate($rating);
        $this->assertNull($accommodation->getRating());
    }

    public function testSetCategory_shouldThrowException_WhenCategorySettedIsNotValid()
    {
        $this->expectException(BusinessRuleException::class);

        $accommodation = new Accommodation();
        $accommodation->setCategory("nonExistentCategory");
        $this->assertNull($accommodation->getCategory());
    }

    public function testSetCategory_shouldSetCategory_WhenCategorySettedIsValid()
    {
        $category = Category::EXISTENT_CATEGORIES["hotel"];
        $accommodation = new Accommodation();
        $accommodation->setCategory($category);
        $this->assertEquals($category, $accommodation->getCategory());
    }

    public function testSetImage_shouldThrowException_WhenImageIsNotAValidUrl()
    {
        $this->expectException(BusinessRuleException::class);

        $accommodation = new Accommodation();
        $accommodation->setImage("thisIsNotAnUrl");
        $this->assertNull($accommodation->getImage());
    }
    
    public function testSetImage_shouldSetImageUrl_WhenItIsAValidUrl()
    {
        $imageUrl = "http://trivago.com/logo.jpg";
        $accommodation = new Accommodation();
        $accommodation->setImage($imageUrl);
        $this->assertEquals($imageUrl, $accommodation->getImage());
    }
}
