<?php

namespace VideoGamesRecords\DwhBundle\DataProvider\Strategy\Core;

use DateTime;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\CoreStrategyInterface;

class CorePlayerStrategy extends AbstractCoreProvider implements CoreStrategyInterface
{
    public function supports(string $name): bool
    {
        return $name === self::TYPE_PLAYER;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $conn = $this->em->getConnection();
        $sql = "SELECT p.id,
                   p.chartRank0,
                   p.chartRank1,
                   p.chartRank2,
                   p.chartRank3,
                   p.pointChart,
                   p.rankPointChart,
                   p.rankMedal,
                   p.nbChart,
                   p.pointGame,
                   p.rankPointGame                   
            FROM vgr_player p
            WHERE p.id <> 0";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }

    /**
     * @return array
     */
    public function getDataRank(): array
    {
        $query = $this->em->createQuery("
                    SELECT
                         p.id,
                         CASE WHEN pc.rank > 29 THEN 30 ELSE pc.rank END AS rank,
                         COUNT(pc.id) as nb
                    FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
                    JOIN pc.player p
                    WHERE pc.rank > 3            
                    GROUP BY p.id, rank");

        $result = $query->getResult();
        $data = array();
        foreach ($result as $row) {
            $data[$row['id']][$row['rank']] = $row['nb'];
        }
        return $data;
    }

    /**
     * @param DateTime $date1
     * @param DateTime $date2
     * @return array
     */
    public function getNbPostDay(DateTime $date1, DateTime $date2): array
    {
        $query = $this->em->createQuery("
            SELECT
                 p.id,
                 COUNT(pc.chart) as nb
            FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
            JOIN pc.player p
            WHERE pc.lastUpdate BETWEEN :date1 AND :date2
            GROUP BY p.id");


        $query->setParameter('date1', $date1);
        $query->setParameter('date2', $date2);
        $result = $query->getResult();

        $data = array();
        foreach ($result as $row) {
            $data[$row['id']] = $row['nb'];
        }
        return $data;
    }
}
