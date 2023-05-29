<?php

namespace VideoGamesRecords\DwhBundle\Contracts\DataProvider;

use DateTime;

interface CoreProviderInterface
{
    public function getData(): mixed;

    public function getNbPostDay(DateTime $date1, DateTime $date2): array;
}
