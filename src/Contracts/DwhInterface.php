<?php
namespace VideoGamesRecords\DwhBundle\Contracts;

interface DwhInterface
{
    const TYPE_GAME = 'game';
    const TYPE_PLAYER = 'player';
    const TYPE_TEAM = 'team';

    const COMMAND_TYPES = [
        self::TYPE_GAME => 1,
        self::TYPE_PLAYER => 1,
        self::TYPE_TEAM => 1,
    ];

    const COMMAND_FUNCTIONS = [
        'process' => 1,
        'purge' => 1,
    ];
}
