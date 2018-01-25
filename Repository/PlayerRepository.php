<?php

namespace VideoGamesRecords\DwhBundle\Repository;

use Doctrine\ORM\EntityRepository;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;
use \DateTime;

class PlayerRepository extends EntityRepository
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
            SELECT p.idPlayer,
                   SUM(p.nbPostDay) as nb      
            FROM VideoGamesRecords\DwhBundle\Entity\Player p
            WHERE p.date BETWEEN :begin AND :end
            GROUP BY p.idPlayer
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
    public function getTotalNbPlayer($begin, $end)
    {
        $query = $this->_em->createQuery("
            SELECT COUNT(DISTINCT(p.idPlayer)) as nb
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalNbPostDay($begin, $end)
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
