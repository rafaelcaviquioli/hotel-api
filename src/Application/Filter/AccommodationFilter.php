<?php

namespace App\Application\Filter;

class AccommodationFilter
{
    private $rating;
    private $city;
    private $reputationBadge;
    private $availabilityMoreThan;
    private $availabilityLessThan;
    private $category;

    public function __construct(
        $rating,
        $city,
        $reputationBadge,
        $availabilityMoreThan,
        $availabilityLessThan,
        $category
    ) {
        $this->rating = $rating;
        $this->city = $city;
        $this->reputationBadge = $reputationBadge;
        $this->availabilityMoreThan = $availabilityMoreThan;
        $this->availabilityLessThan = $availabilityLessThan;
        $this->category = $category;
    }

    public function getRating()
    {
        return $this->rating;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getReputationBadge()
    {
        return $this->reputationBadge;
    }
    public function getAvailabilityMoreThan()
    {
        return $this->availabilityMoreThan;
    }
    public function getAvailabilityLessThan()
    {
        return $this->availabilityLessThan;
    }
    public function getCategory()
    {
        return $this->category;
    }
}
