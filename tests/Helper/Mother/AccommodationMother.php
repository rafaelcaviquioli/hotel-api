<?php

namespace App\Tests\Helper\Mother;

use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;

class AccommodationMother
{
    private static function getValidBaseAccommodation(int $id = null): Accommodation
    {
        $location = new Location();
        $location
            ->setCity("Cuernavaca")
            ->setState("Morelos")
            ->setCountry("Mexico")
            ->setZipCode(12345)
            ->setAddress("Boulevard Díaz Ordaz No. 9 Cantarranas");

        $accommodation = new Accommodation($id);
        $accommodation
            ->setName("Hotel is Trivago")
            ->setRating(5)
            ->setCategory("hotel")
            ->setLocation($location)
            ->setImage("http://www.trivago.com/photo.jpg")
            ->setReputation(1000)
            ->setPrice(800)
            ->setAvailability(1000);

        return $accommodation;
    }

    public static function getUnavailableAccommodation($id = null): Accommodation
    {
        $accommodation = AccommodationMother::getValidBaseAccommodation($id);
        $accommodation->setAvailability(0);
        
        return $accommodation;
    }

    public static function getAvailableAccommodation(int $availability, int $id = null): Accommodation
    {
        $accommodation = AccommodationMother::getValidBaseAccommodation($id);
        $accommodation->setAvailability($availability);
        
        return $accommodation;
    }
}
