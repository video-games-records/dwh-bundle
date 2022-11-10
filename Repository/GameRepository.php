<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class GameRepository extends EntityRepository
{
    /**
     * @param DateTime $begin
     * @param DateTime $end
     * @param integer  $limit
     * @return array
     */
    public function getTop(DateTime $begin, DateTime $end, int $limit = 20): array
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
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNbGame(DateTime $begin, DateTime $end): mixed
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
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalNbPostDay(DateTime $begin, DateTime $end): mixed
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
