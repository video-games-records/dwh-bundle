<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Contracts;

interface DwhInterface
{
    public const TYPE_GAME = 'game';
    public const TYPE_PLAYER = 'player';
    public const TYPE_TEAM = 'team';

    public const COMMAND_TYPES = [
        self::TYPE_GAME => 1,
        self::TYPE_PLAYER => 1,
        self::TYPE_TEAM => 1,
    ];

    public const COMMAND_FUNCTIONS = [
        'process' => 1,
        'purge' => 1,
    ];
}
