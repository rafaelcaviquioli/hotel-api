<?php

namespace App\Application\ViewModel;

use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class LocationViewModel
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

    public function __construct(Location $location)
    {
        $this->city = $location->getCity();
        $this->state = $location->getState();
        $this->country = $location->getCountry();
        $this->address = $location->getAddress();
        $this->zip_code = $location->getZipCode();
    }
}

class AccommodationViewModel
{
    /**
     * @SWG\Property(type="integer")
     */
    public $id;

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
     * @SWG\Property(ref=@Model(type=LocationViewModel::class))
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
     * @SWG\Property(type="string")
     */
    public $reputationBadge;

    /**
     * @SWG\Property(type="integer")
     */
    public $price;

    /**
     * @SWG\Property(type="integer")
     */
    public $availability;

    public function parseOne(Accommodation $accommodation): void
    {
        $this->id = $accommodation->getId();
        $this->name = $accommodation->getName();
        $this->rating = $accommodation->getRating();
        $this->category = $accommodation->getCategory();
        $this->location = new LocationViewModel($accommodation->getLocation());
        $this->image = $accommodation->getImage();
        $this->reputation = $accommodation->getReputation();
        $this->reputationBadge = $accommodation->getReputationBadge()->__toString();
        $this->price = $accommodation->getPrice();
        $this->availability = $accommodation->getAvailability();
    }

    public static function parseList(array $accommodations): array
    {
        $mapAccommodations = function (Accommodation $accommodation): AccommodationViewModel {
            $viewModel = new AccommodationViewModel();
            $viewModel->parseOne($accommodation);

            return $viewModel;
        };

        return array_map($mapAccommodations, $accommodations);
    }
}
