<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VideoGamesRecords\DwhBundle\Entity\Game as DwhGame;

class GameRepository extends EntityRepository
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
                 g.idGame,
                 COUNT(pc.idChart) as nb
            FROM VideoGamesRecords\CoreBundle\Entity\PlayerChart pc
            JOIN pc.chart c
            JOIN c.group g
            WHERE pc.dateModif BETWEEN :date1 AND :date2
            GROUP BY g.idGame");


        $query->setParameter('date1', $date1);
        $query->setParameter('date2', $date2);
        $result = $query->getResult();

        $data1 = array();
        foreach ($result as $row) {
            $data1[$row['idGame']] = $row['nb'];
        }

        //----- all games
        $query = $this->_em->createQuery("
            SELECT g.id,
                   g.nbPost                  
            FROM VideoGamesRecords\CoreBundle\Entity\Game g");

        $result = $query->getResult();
        foreach ($result as $row) {
            $id = $row['id'];
            $dwhGame = new DwhGame();
            $dwhGame->setDate($date1->format('Y-m-d'));
            $dwhGame->setFromArray($row);
            $dwhGame->setNbPostDay((isset($data1[$id])) ? $data1[$id] : 0);
            $this->_em->persist($dwhGame);
        }

        $this->_em->flush();
    }

    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @param integer $limit
     * @return array
     */
    public function getTop($begin, $end, $limit = 20)
    {
        $query = $this->_em->createQuery("
            SELECT g.id,
                   SUM(g.nbPostDay) as nb      
            FROM VideoGamesRecords\DwhBundle\Entity\Game g
            WHERE g.date BETWEEN :begin AND :end
            GROUP BY g.id
            HAVING nb > 0
            ORDER BY nb DESC");

        $query->setParameter('begin', $begin);
        $query->setParameter('end', $end);
        $query->setMaxResults($limit);

        return $query->getArrayResult();
    }

    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalNbGame($begin, $end)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(DISTINCT(g.id)) as nb
            FROM VideoGamesRecords\DwhBundle\Entity\Game g
            WHERE g.date BETWEEN :begin AND :end
            AND g.nbPostDay > 0");

        $query->setParameter('begin', $begin);
        $query->setParameter('end', $end);

        return $query->getSingleScalarResult();
    }

    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalNbPostDay($begin, $end)
    {
        $query = $this->_em->createQuery("
            SELECT SUM(g.nbPostDay) as nb
            FROM VideoGamesRecords\DwhBundle\Entity\Game g
            WHERE g.date BETWEEN :begin AND :end");

        $query->setParameter('begin', $begin);
        $query->setParameter('end', $end);

        return $query->getSingleScalarResult();
    }
}
