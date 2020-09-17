<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;

class Player
{
    private $dwhEntityManager;
    private $defaultEntityManager;
    private $playerRepository;

    public function __construct(EntityManager $dwhEntityManager, EntityManager $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
        $this->playerRepository = $dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Player');
    }

    /**
     * @throws \Exception
     */
    public function maj()
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:PlayerChart')->getNbPostDay($date1, $date2);

        $data2 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:PlayerChart')->getDataRank();

        $list = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Player')->getDataForDwh();

        foreach ($list as $row) {
            $idPlayer = $row['id'];
            $dwhPlayer = new DwhPlayer();
            $dwhPlayer->setDate($date1->format('Y-m-d'));
            $dwhPlayer->setFromArray($row);
            $dwhPlayer->setNbPostDay((isset($data1[$idPlayer])) ? $data1[$idPlayer] : 0);
            if (isset($data2[$idPlayer])) {
                foreach ($data2[$idPlayer] as $key => $value) {
                    $dwhPlayer->setChartRank($key, $value);
                }
            }
            $this->dwhEntityManager->persist($dwhPlayer);
        }

        $this->dwhEntityManager->flush();
    }

    /**
     * @throws \Exception
     */
    public function purge()
    {
        $date = new DateTime();
        $date = $date->sub(DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Player p WHERE p.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }

    /**
     * @param DateTime $date1Begin
     * @param DateTime $date1End
     * @param DateTime $date2Begin
     * @param DateTime $date2End
     * @param integer  $limit
     * @return array
     */
    public function getTop(DateTime $date1Begin, DateTime $date1End, DateTime $date2Begin, DateTime $date2End, $limit = 20)
    {
        $playerList1 = $this->playerRepository->getTop(
            $date1Begin,
            $date1End,
            $limit
        );
        $playerList2 = $this->playerRepository->getTop(
            $date2Begin,
            $date2End,
            $limit
        );

        // Get old rank
        $oldRank = array();
        foreach ($playerList2 as $key => $row) {
            $oldRank[$row['id']] = $key + 1;
        }

        $nbPostFromList = 0;
        for ($i=0, $nb=count($playerList1) - 1; $i <= $nb; ++$i) {
            $idPlayer = $playerList1[$i]['id'];
            if (isset($oldRank[$idPlayer])) {
                $playerList1[$i]['oldRank'] = $oldRank[$idPlayer];
            } else {
                $playerList1[$i]['oldRank'] = null;
            }
            $player = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Player')->find($idPlayer);
            $playerList1[$i]['player'] = $player;
            $nbPostFromList += $playerList1[$i]['nb'];
        }

        $nbPlayer = $this->playerRepository->getTotalNbPlayer($date1Begin, $date1End);
        $nbTotalPost = $this->playerRepository->getTotalNbPostDay($date1Begin, $date1End);

        $playerList = ToolsRanking::addRank(
            $playerList1,
            'rank',
            ['nb'],
            true
        );

        return array(
            'list' => $playerList,
            'nbPostFromList' => $nbPostFromList,
            'nb' => $nbPlayer,
            'nbTotalPost' => $nbTotalPost,
        );
    }
}
