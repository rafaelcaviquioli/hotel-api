<?php

namespace App\Domain\Entity;

use App\CrossCutting\Exception\ValidationEntityException;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Constant\Category;
use App\Domain\ObjectValue\ReputationBadge;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\AccommodationRepository")
 */
class Accommodation
{
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
        if (strlen($name) <= 10) {
            throw new ValidationEntityException("The accommodation name should be longer than 10 characters.");
        }

        $forbidenWords =  ["Free", "Offer", "Book", "Website"];
        foreach ($forbidenWords as $word) {
            if (stripos($name, $word) > -1) {
                throw new ValidationEntityException("Was not possible set accommodation name because '$name' is a forbiden word.");
            }
        }

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
        if (filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {
            throw new ValidationEntityException("The image url '$imageUrl' is not a valid URL");
        }

        $this->image = $imageUrl;

        return $this;
    }

    public function setCategory($category): self
    {
        if (!Category::validateCategory($category)) {
            throw new ValidationEntityException("The category '$category' is invalid");
        }

        $this->category = $category;

        return $this;
    }

    public function setRating(int $rating): self
    {
        if ($rating < 0 || $rating > 5) {
            throw new ValidationEntityException("The evaluate rating is invalid");
        }

        $this->rating = $rating;

        return $this;
    }

    public function setReputation(int $reputation): self
    {
        if ($reputation < 0 || $reputation > 1000) {
            throw new ValidationEntityException("The reputation is invalid");
        }

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

    public function isAvailable(): bool
    {
        return $this->availability > 0;
    }

    public function book(): self
    {
        if (!$this->isAvailable()) {
            throw new ValidationEntityException("This accommodation there is no availability.");
        }

        $this->availability = $this->availability - 1;

        return $this;
    }
}
