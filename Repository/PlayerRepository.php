<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VideoGamesRecords\CoreBundle\Entity\Player as VgrPlayer;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;

class PlayerRepository extends EntityRepository
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function maj()
    {

        $date1 = new \DateTime();
        $date1->sub(new \DateInterval('P1D'));
        $date2 = new \DateTime();

        //----- data nbPostDay
        $query = $this->_em->createQuery("
            SELECT
                 pc.idPlayer,
                 COUNT(pc.idChart) as nb
            FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
            WHERE pc.dateModif BETWEEN :date1 AND :date2
            GROUP BY pc.idPlayer");


        $query->setParameter('date1', $date1);
        $query->setParameter('date2', $date2);
        $result = $query->getResult();

        $data1 = array();
        foreach ($result as $row) {
            $data1[$row['idPlayer']] = $row['nb'];
        }

        //----- data rank
        $query = $this->_em->createQuery("
            SELECT
                 pc.idPlayer,
                 CASE WHEN pc.rank > 29 THEN 30 ELSE pc.rank AS rank,
                 COUNT(pc.idPlayerChart) as nb
            FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
            WHERE pc.rank > 3
            GROUP BY pc.idPlayer, rank");

        $result = $query->getResult();
        $data2 = array();
        foreach ($result as $row) {
            $data2[$row['idPlayer']][$row['rank']] = $row['nb'];
        }

        //----- all players
        $query = $this->_em->createQuery("
            SELECT p.idPlayer,
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
            FROM VideoGamesRecords\CoreBundle\Entity\Player p");




        $result = $query->getResult();
        foreach ($result as $row) {
            $idPlayer = $row['idPlayer'];
            $dwhPlayer = new DwhPlayer();
            $dwhPlayer->setDate($date1);
            $dwhPlayer->setFromArray($row);
            $dwhPlayer->setNbPostDay((isset($data1[$idPlayer])) ? $data1[$idPlayer] : 0);
            if (isset($data2[$idPlayer])) {
                foreach ($data2[$idPlayer] as $key => $value) {
                    $dwhPlayer->setChartRank($key, $value);
                }
            }
            $this->_em->persist($dwhPlayer);
        }

        $this->_em->flush();
    }
}
