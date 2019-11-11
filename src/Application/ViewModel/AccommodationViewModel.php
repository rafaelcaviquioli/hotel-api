<?php
namespace App\Application\ViewModel;

use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;

class LocationViewModel
{
    public $city;
    public $state;
    public $country;
    public $address;
    public $zipCode;

    public function __construct(Location $location)
    {
        $this->city = $location->getCity();
        $this->state = $location->getState();
        $this->country = $location->getCountry();
        $this->address = $location->getAddress();
        $this->zipCode = $location->getZipCode();
    }
}

class AccommodationViewModel
{
    public $id;
    public $name;
    public $rating;
    public $category;
    public $location;
    public $image;
    public $reputationBadge;
    public $price;
    public $availability;

    public function parseOne(Accommodation $accommodation): void
    {
        $this->id = $accommodation->getId();
        $this->name = $accommodation->getName();
        $this->rating = $accommodation->getRating();
        $this->category = $accommodation->getCategory();
        $this->location = new LocationViewModel($accommodation->getLocation());
        $this->image = $accommodation->getImage();
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
