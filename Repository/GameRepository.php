<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VideoGamesRecords\DwhBundle\Entity\Game as DwhGame;

class GameRepository extends EntityRepository
{

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
