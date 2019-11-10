<?php

namespace App\Domain\ObjectValue;

use Exception;

class ReputationBadge
{
    public const RED = "red";
    public const YELLOW = "yellow";
    public const GREEN = "green";

    private $badge;

    public function __construct(int $reputation)
    {
        $this->badge = $this->reputationToBadge($reputation);
    }

    private function reputationToBadge($reputation): string
    {
        if (self::isRed($reputation))
            return self::RED;

        if (self::isYellow($reputation))
            return self::YELLOW;

        if (self::isGreen($reputation))
            return self::GREEN;

        throw new Exception("Was not possible define badge from reputation: '$reputation'");
    }

    private static function isRed($reputation): bool
    {
        return $reputation <= 500;
    }

    private static function isYellow($reputation): bool
    {
        return $reputation > 500 && $reputation <= 799;
    }

    private static function isGreen($reputation): bool
    {
        return $reputation > 799;
    }

    public function __toString(): string
    {
        return $this->badge;
    }
}
