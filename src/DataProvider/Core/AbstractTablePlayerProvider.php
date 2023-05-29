<?php

namespace VideoGamesRecords\DwhBundle\DataProvider\Core;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use VideoGamesRecords\DwhBundle\Contracts\DataProvider\CoreProviderInterface;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;

class AbstractTablePlayerProvider implements DwhInterface, CoreProviderInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return array();
    }

    /**
     * @param DateTime $date1
     * @param DateTime $date2
     * @return array
     */
    public function getNbPostDay(DateTime $date1, DateTime $date2): array
    {
        return array();
    }
}

