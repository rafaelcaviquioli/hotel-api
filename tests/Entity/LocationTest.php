<?php

namespace App\Tests\Entity;

use Exception;
use App\Domain\Entity\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testSetZipCode_ShouldThrowException_WhenZipCodeLengthIsBiggerThanFive5()
    {
        $this->expectException(Exception::class);

        $zipCode = 123456789;
        $location = new Location();
        $location->setZipCode($zipCode);
    }
    public function testSetZipCode_ShouldThrowException_WhenZipCodeLengthIsLesserThanFive5()
    {
        $this->expectException(Exception::class);

        $zipCode = 1234;
        $location = new Location();
        $location->setZipCode($zipCode);
    }
    public function testSetZipCode_ShouldSetZipCode_WhenZipCodeHaveLengthOf5()
    {
        $zipCode = 12345;
        $location = new Location();
        $location->setZipCode($zipCode);
        $this->assertEquals($zipCode, $location->getZipCode());
    }
}
