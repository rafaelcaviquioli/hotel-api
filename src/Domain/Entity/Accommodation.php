<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Api\Exception\BusinessRuleException;
use App\Domain\Constant\Category;

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

    public function __construct()
    { }

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

    public function setReputation(int $reputation): self
    {
        $this->reputation = $reputation;

        return $this;
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
            throw new BusinessRuleException("The image url '$imageUrl' is not a valid URL");
        }

        $this->image = $imageUrl;

        return $this;
    }

    public function setCategory($category): self
    {
        if (!Category::validateCategory($category)) {
            throw new BusinessRuleException("The category '$category' is invalid");
        }

        $this->category = $category;

        return $this;
    }

    public function setEvaluate(int $rating): self
    {
        if ($rating < 0 || $rating > 5) {
            throw new BusinessRuleException("The evaluate rating is invalid");
        }

        $this->rating = $rating;

        return $this;
    }
}
