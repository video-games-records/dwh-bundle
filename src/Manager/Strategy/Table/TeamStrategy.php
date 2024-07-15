<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Manager\Strategy\Table;

use DateInterval;
use DateTime;
use Exception;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\TableStrategyInterface;
use VideoGamesRecords\DwhBundle\Entity\Team as DwhTeam;

class TeamStrategy extends AbstractTableManager implements TableStrategyInterface
{
    public function supports(string $name): bool
    {
        return $name === self::TYPE_TEAM;
    }


    /**
     * @throws Exception
     */
    public function process(): void
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->provider->getNbPostDay($date1, $date2);
        $list = $this->provider->getData();

        foreach ($list as $row) {
            $idTeam = $row['id'];
            $dwhTeam = new DwhTeam();
            $dwhTeam->setDate($date1->format('Y-m-d'));
            $dwhTeam->setFromArray($row);
            $dwhTeam->setNbPostDay((isset($data1[$idTeam])) ? $data1[$idTeam] : 0);
            $this->em->persist($dwhTeam);
        }

        $this->em->flush();
    }

    /**
     * @throws Exception
     */
    public function purge(): void
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->em->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Team t WHERE t.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
