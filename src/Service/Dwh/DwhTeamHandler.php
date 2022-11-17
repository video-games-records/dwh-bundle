<?php

namespace VideoGamesRecords\DwhBundle\Service\Dwh;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use VideoGamesRecords\CoreBundle\Service\Dwh\DwhTeamProvider;
use VideoGamesRecords\DwhBundle\Entity\Team as DwhTeam;
use VideoGamesRecords\DwhBundle\Interface\DwhTableInterface;

class DwhTeamHandler implements DwhTableInterface
{
    private EntityManager $dwhEntityManager;
    private DwhTeamProvider $dwhTeamProvider;

    public function __construct(EntityManager $dwhEntityManager, DwhTeamProvider $dwhTeamProvider)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->dwhTeamProvider = $dwhTeamProvider;
    }

    /**
     * @throws Exception
     */
    public function process(): void
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->dwhTeamProvider->getNbPostDay($date1, $date2);
        $list = $this->dwhTeamProvider->getDataForDwh();

        foreach ($list as $row) {
            $idTeam = $row['id'];
            $dwhTeam = new DwhTeam();
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
    public function purge(): void
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Team t WHERE t.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
