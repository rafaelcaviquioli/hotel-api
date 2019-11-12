<?php

namespace App\Domain\Service;

use App\Application\ViewModel\AccommodationViewModel;
use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;
use App\Infrastructure\Repository\AccommodationRepository;

class AccommodationService
{
    private $accommodationRepository;

    public function __construct(AccommodationRepository $accommodationRepository)
    {
        $this->accommodationRepository = $accommodationRepository;
    }

    public function createAccommodation(array $content): AccommodationViewModel
    {
        $location = new Location();
        $location
            ->setCity($content["location"]["city"])
            ->setState($content["location"]["state"])
            ->setCountry($content["location"]["country"])
            ->setAddress($content["location"]["address"])
            ->setZipCode((int) $content["location"]["zip_code"]);

        $accommodation = new Accommodation();
        $accommodation
            ->setName($content["name"])
            ->setCategory($content["category"])
            ->setLocation($location)
            ->setPrice((int) $content["price"])
            ->setAvailability((int) $content["availability"])
            ->setImage($content["image"])
            ->setReputation((int) $content["reputation"])
            ->setRating((int) $content["rating"]);

        $this->accommodationRepository->create($accommodation);

        $viewModel = new AccommodationViewModel();
        $viewModel->parseOne($accommodation);

        return $viewModel;
    }
}
