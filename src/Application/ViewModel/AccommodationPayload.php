<?php

namespace App\Application\ViewModel;

use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class LocationPayload
{
    /**
     * @SWG\Property(type="string")
     */
    public $city;

    /**
     * @SWG\Property(type="string")
     */
    public $state;

    /**
     * @SWG\Property(type="string")
     */
    public $country;

    /**
     * @SWG\Property(type="string")
     */
    public $address;

    /**
     * @SWG\Property(type="integer")
     */
    public $zip_code;
}

class AccommodationPayload
{
    /**
     * @SWG\Property(type="string")
     */
    public $name;

    /**
     * @SWG\Property(type="integer")
     */
    public $rating;

    /**
     * @SWG\Property(type="string")
     */
    public $category;

    /**
     * @SWG\Property(ref=@Model(type=LocationPayload::class))
     */
    public $location;

    /**
     * @SWG\Property(type="string")
     */
    public $image;

    /**
     * @SWG\Property(type="integer")
     */
    public $reputation;

    /**
     * @SWG\Property(type="integer")
     */
    public $price;

    /**
     * @SWG\Property(type="integer")
     */
    public $availability;
}
