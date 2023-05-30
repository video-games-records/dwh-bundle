<?php

namespace VideoGamesRecords\DwhBundle\DataProvider\Strategy\Top;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use VideoGamesRecords\DwhBundle\Contracts\DataProvider\TopProviderInterface;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;

class AbstractTopProvider implements DwhInterface, TopProviderInterface
{
    protected EntityManagerInterface $dwhEntityManager;
    protected EntityManagerInterface $defaultEntityManager;

    public function __construct(EntityManagerInterface $dwhEntityManager, EntityManagerInterface $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
    }


    public function getTop(
        DateTime $date1Begin, DateTime $date1End, DateTime $date2Begin, DateTime $date2End, int $limit = 20
    ): array
    {
        return array();
    }
}
