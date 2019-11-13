<?php

namespace App\Domain\BusinessConstraint;

use App\CrossCutting\Exception\ValidationEntityException;

class AccommodationBusinessConstraint
{
    public static function validateNameLength(string $name): void
    {
        if (strlen($name) <= 10) {
            throw new ValidationEntityException("The accommodation name should be longer than 10 characters.");
        }
    }

    public static function validateForbidenName(string $name): void
    {
        $forbidenWords =  ["Free", "Offer", "Book", "Website"];
        foreach ($forbidenWords as $word) {
            if (stripos($name, $word) > -1) {
                throw new ValidationEntityException("Was not possible set accommodation name because '$name' is a forbiden word.");
            }
        }
    }

    public static function validateCategory(string $category): void
    {
        $existentCategories = [
            "hotel" => "hotel",
            "alternative" => "alternative",
            "hoste" => "hoste",
            "lodge" => "lodge",
            "resort" => "resort",
            "guest-hous" => "guest-hous"
        ];

        if (!in_array($category, $existentCategories)) {
            throw new ValidationEntityException("The category '$category' is invalid");
        }
    }

    public static function validateImageUrl(string $imageUrl): void
    {
        if (filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {
            throw new ValidationEntityException("The image url '$imageUrl' is not a valid URL");
        }
    }

    public static function validateRating(int $rating): void
    {
        if ($rating < 0 || $rating > 5) {
            throw new ValidationEntityException("The evaluate rating is invalid");
        }
    }
    public static function validateReputation(int $reputation): void
    {
        if ($reputation < 0 || $reputation > 1000) {
            throw new ValidationEntityException("The reputation is invalid");
        }
    }
    public static function validateIsAvailability(int $availability): void
    {
        if ($availability < 1) {
            throw new ValidationEntityException("Accommodation is not availability.");
        }
    }
}
