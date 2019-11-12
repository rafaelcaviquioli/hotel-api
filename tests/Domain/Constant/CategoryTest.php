<?php

namespace App\Tests\Domain\Constant;

use App\Domain\Constant\Category;
use Exception;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testValidateCategory_ShouldReturnTrue_WhenCategoryIsValid()
    {
        $this->assertTrue(Category::validateCategory("hotel"), "Because it's a valid category");
    }

    public function testValidateCategory_ShouldReturnFalse_WhenCategoryIsInvalid()
    {
        $this->assertFalse(Category::validateCategory("bathrooms"), "Because it's an invalid category");
    }
}
