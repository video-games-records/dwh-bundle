<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Contracts\Strategy;

use Datetime;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;

interface TopStrategyInterface extends DwhInterface
{
    public function supports(string $name): bool;

    public function getTop(
        DateTime $date1Begin,
        DateTime $date1End,
        DateTime $date2Begin,
        DateTime $date2End,
        int $limit = 20
    ): array;
}
