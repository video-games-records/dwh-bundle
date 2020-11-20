<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class PlayerRepository extends EntityRepository
{
    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @param integer  $limit
     * @return array
     */
    public function getTop(DateTime $begin, DateTime $end, $limit = 20)
    {
        $query = $this->_em->createQuery("
            SELECT p.id,
                   SUM(p.nbPostDay) as nb      
            FROM VideoGamesRecords\DwhBundle\Entity\Player p
            WHERE p.date BETWEEN :begin AND :end
            GROUP BY p.id
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
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNbPlayer(DateTime $begin, DateTime $end)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(DISTINCT(p.id)) as nb
            FROM VideoGamesRecords\DwhBundle\Entity\Player p
            WHERE p.date BETWEEN :begin AND :end
            AND p.nbPostDay > 0");

        $query->setParameter('begin', $begin);
        $query->setParameter('end', $end);

        return $query->getSingleScalarResult();
    }

    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNbPostDay(DateTime $begin, DateTime $end)
    {
        $query = $this->_em->createQuery("
            SELECT SUM(p.nbPostDay) as nb
            FROM VideoGamesRecords\DwhBundle\Entity\Player p
            WHERE p.date BETWEEN :begin AND :end");

        $query->setParameter('begin', $begin);
        $query->setParameter('end', $end);

        return $query->getSingleScalarResult();
    }
}
