<?php

namespace VideoGamesRecords\DwhBundle\DataProvider\Strategy\Core;

use VideoGamesRecords\DwhBundle\Contracts\Strategy\CoreStrategyInterface;

class CoreGameStrategy extends AbstractCoreProvider implements CoreStrategyInterface
{
    public function supports(string $name): bool
    {
        return $name === self::TYPE_GAME;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->em->getRepository('VideoGamesRecords\CoreBundle\Entity\Game')
            ->findAll();
    }

    /**
     * @param $date1
     * @param $date2
     * @return array
     */
    public function getNbPostDay($date1, $date2): array
    {
        //----- data nbPostDay
        $query = $this->em->createQuery(
            "
            SELECT
                 ga.id,
                 COUNT(pc.id) as nb
            FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
            JOIN pc.chart c
            JOIN c.group gr
            JOIN gr.game ga
            WHERE pc.lastUpdate BETWEEN :date1 AND :date2
            GROUP BY ga.id"
        );

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

