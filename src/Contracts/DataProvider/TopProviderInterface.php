<?php

namespace VideoGamesRecords\DwhBundle\Contracts\DataProvider;

use DateTime;

interface TopProviderInterface
{
    public function getTop(
        DateTime $date1Begin,
        DateTime $date1End,
        DateTime $date2Begin,
        DateTime $date2End,
        int $limit = 20
    ): array;
}
