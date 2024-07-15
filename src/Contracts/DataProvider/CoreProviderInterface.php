<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Contracts\DataProvider;

use DateTime;

interface CoreProviderInterface
{
    public function getData(): array;

    public function getNbPostDay(DateTime $date1, DateTime $date2): array;
}
