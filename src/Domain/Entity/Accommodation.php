<?php

namespace App\Domain\Entity;

use App\CrossCutting\Exception\ValidationEntityException;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\BusinessConstraint\AccommodationBusinessConstraint;
use App\Domain\ObjectValue\ReputationBadge;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\AccommodationRepository")
 */
class Accommodation
{
    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="smallint")
     */
    private $rating;

    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\Location", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $reputation;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="smallint")
     */
    private $availability;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        AccommodationBusinessConstraint::validateNameLength($name);
        AccommodationBusinessConstraint::validateForbidenName($name);

        $this->name = $name;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getReputation(): ?int
    {
        return $this->reputation;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setImage(string $imageUrl): self
    {
        AccommodationBusinessConstraint::validateImageUrl($imageUrl);

        $this->image = $imageUrl;

        return $this;
    }

    public function setCategory($category): self
    {
        AccommodationBusinessConstraint::validateCategory($category);

        $this->category = $category;

        return $this;
    }

    public function setRating(int $rating): self
    {
        AccommodationBusinessConstraint::validateRating($rating);

        $this->rating = $rating;

        return $this;
    }

    public function setReputation(int $reputation): self
    {
        AccommodationBusinessConstraint::validateReputation($reputation);

        $this->reputation = $reputation;

        return $this;
    }

    public function getReputationBadge(): ReputationBadge
    {
        if ($this->reputation == null) {
            throw new ValidationEntityException("The reputation is null");
        }

        return new ReputationBadge($this->reputation);
    }

    public function book(): self
    {
        AccommodationBusinessConstraint::validateIsAvailability($this->availability);

        $this->availability = $this->availability - 1;

        return $this;
    }
}
