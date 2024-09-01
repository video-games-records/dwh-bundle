<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\ValueObject;

use Webmozart\Assert\Assert;

class Target
{
    public const GAME = 'game';
    public const PLAYER = 'PLAYER';
    public const TEAM = 'TEAM';

    public const VALUES = [
        self::GAME,
        self::PLAYER,
        self::TEAM,
    ];

    private string $value;

    public function __construct(string $value)
    {
        self::inArray($value);

        $this->value = $value;
    }

    public static function inArray(string $value): void
    {
        Assert::inArray($value, self::VALUES);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
