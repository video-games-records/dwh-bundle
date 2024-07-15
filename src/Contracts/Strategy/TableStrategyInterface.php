<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Contracts\Strategy;

use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;

interface TableStrategyInterface extends DwhInterface
{
    public function supports(string $name): bool;

    public function process(): void;

    public function purge(): void;
}
