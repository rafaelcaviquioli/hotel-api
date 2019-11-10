<?php

namespace App\Domain\ObjectValue;

use Exception;

class ReputationBadge
{
    public const RED = "red";
    public const YELLOW = "yellow";
    public const GREEN = "green";

    private $reputation;
    private $badge;

    public function __construct(int $reputation)
    {
        $this->reputation = $reputation;
        
        if ($this->isRed()) {
            $this->badge = self::RED;
        } elseif ($this->isYellow()) {
            $this->badge = self::YELLOW;
        } elseif ($this->isGreen()) {
            $this->badge = self::GREEN;
        } else {
            throw new Exception("Was not possible define badge from reputation: '{$this->reputation}'");
        }
    }

    private function isRed(): bool
    {
        return $this->reputation <= 500;
    }

    private function isYellow(): bool
    {
        return $this->reputation > 500 && $this->reputation <= 799;
    }

    private function isGreen(): bool
    {
        return $this->reputation > 799;
    }

    public function __toString(): string
    {
        return $this->badge;
    }
}
