<?php

namespace VideoGamesRecords\DwhBundle\Contracts\Strategy;

use Datetime;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;

interface CoreStrategyInterface extends DwhInterface
{
    public function supports(string $name): bool;

    public function getData(): array;

    public function getNbPostDay(DateTime $date1, DateTime $date2): array;
}
