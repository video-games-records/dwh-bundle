<?php

namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use VideoGamesRecords\DwhBundle\Entity\Team as DwhTeam;
use VideoGamesRecords\DwhBundle\Repository\TeamRepository;

class TeamService
{
    private $dwhEntityManager;
    private $defaultEntityManager;

    /** @var TeamRepository  */
    private $teamRepository;

    public function __construct(EntityManager $dwhEntityManager, EntityManager $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
        $this->teamRepository = $dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Team');
    }

    /**
     * @throws Exception
     */
    public function maj()
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Team')->getNbPostDay($date1, $date2);

        $list = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Team')->getDataForDwh();

        foreach ($list as $row) {
            $idTeam = $row['id'];
            $dwhTeam= new DwhTeam();
            $dwhTeam->setDate($date1->format('Y-m-d'));
            $dwhTeam->setFromArray($row);
            $dwhTeam->setNbPostDay((isset($data1[$idTeam])) ? $data1[$idTeam] : 0);
            $this->dwhEntityManager->persist($dwhTeam);
        }

        $this->dwhEntityManager->flush();
    }

    /**
     * @throws Exception
     */
    public function purge()
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Team t WHERE t.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}