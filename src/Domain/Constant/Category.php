<?php

namespace App\Domain\Constant;

class Category
{
    const EXISTENT_CATEGORIES = [
        "hotel" => "hotel",
        "alternative" => "alternative",
        "hoste" => "hoste",
        "lodge" => "lodge",
        "resort" => "resort",
        "guest-hous" => "guest-hous"
    ];

    public static function validateCategory(string $category): bool
    {
        return in_array($category, self::EXISTENT_CATEGORIES);
    }
}
