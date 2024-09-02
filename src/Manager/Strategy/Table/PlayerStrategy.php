<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Manager\Strategy\Table;

use DateInterval;
use DateTime;
use Exception;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\TableStrategyInterface;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;

class PlayerStrategy extends AbstractTableManager implements TableStrategyInterface
{
    public function supports(string $name): bool
    {
        return $name === self::TYPE_PLAYER;
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
        $data2 = $this->provider->getDataRank();
        $list = $this->provider->getData();

        foreach ($list as $row) {
            $idPlayer = $row['id'];
            $dwhPlayer = new DwhPlayer();
            $dwhPlayer->setDate($date1->format('Y-m-d'));
            $dwhPlayer->setId($row['id']);
            $dwhPlayer->setChartRank0($row['chart_rank0']);
            $dwhPlayer->setChartRank1($row['chart_rank1']);
            $dwhPlayer->setChartRank2($row['chart_rank2']);
            $dwhPlayer->setChartRank3($row['chart_rank3']);
            $dwhPlayer->setPointChart($row['point_chart']);
            $dwhPlayer->setRankPointChart($row['rank_point_chart']);
            $dwhPlayer->setRankMedal($row['rank_medal']);
            $dwhPlayer->setNbChart($row['nb_chart']);
            $dwhPlayer->setPointGame($row['point_game']);
            $dwhPlayer->setRankPointGame($row['rank_point_game']);
            $dwhPlayer->setNbPostDay((isset($data1[$idPlayer])) ? $data1[$idPlayer] : 0);
            if (isset($data2[$idPlayer])) {
                foreach ($data2[$idPlayer] as $key => $value) {
                    $dwhPlayer->setChartRank($key, $value);
                }
            }
            $this->em->persist($dwhPlayer);
            $this->em->flush();
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
        $query = $this->em->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Player p WHERE p.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }
}
