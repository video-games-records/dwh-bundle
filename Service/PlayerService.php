<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository;

class PlayerService
{
    private $dwhEntityManager;
    private $defaultEntityManager;

    /** @var PlayerRepository  */
    private $playerRepository;

    public function __construct(EntityManager $dwhEntityManager, EntityManager $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
        $this->playerRepository = $dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Player');
    }

    /**
     * @throws Exception
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
     * @throws Exception
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

        $nbPlayer = 0;
        try {
            $nbPlayer = $this->playerRepository->getTotalNbPlayer($date1Begin, $date1End);
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        $nbTotalPost = 0;
        try {
            $nbTotalPost = $this->playerRepository->getTotalNbPostDay($date1Begin, $date1End);
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

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

    /**
     * @param $idPlayer
     * @return array
     */
    public function getPositions($idPlayer): array
    {
        $object = $this->playerRepository->findOneBy(array('id' => $idPlayer), array('date' => 'DESC'));
        return array(
            $object->getChartRank1(),
            $object->getChartRank2(),
            $object->getChartRank3(),
            $object->getChartRank(4),
            $object->getChartRank(5),
            $object->getChartRank(6),
            $object->getChartRank(7),
            $object->getChartRank(8),
            $object->getChartRank(9),
            $object->getChartRank(10),
            $object->getChartRank(11),
            $object->getChartRank(12),
            $object->getChartRank(13),
            $object->getChartRank(14),
            $object->getChartRank(15),
            $object->getChartRank(16),
            $object->getChartRank(17),
            $object->getChartRank(18),
            $object->getChartRank(19),
            $object->getChartRank(20),
            $object->getChartRank(21),
            $object->getChartRank(22),
            $object->getChartRank(23),
            $object->getChartRank(24),
            $object->getChartRank(25),
            $object->getChartRank(26),
            $object->getChartRank(27),
            $object->getChartRank(28),
            $object->getChartRank(29),
            $object->getChartRank(30),
        );
    }

     /**
     * @param $idPlayer
     * @return array
     */
    public function getMedalsByTime($idPlayer): array
    {
         $list = $this->playerRepository->findBy(array('id' => $idPlayer), array('date' => 'ASC'));

         $return = [
             'rank0' => [],
             'rank1' => [],
             'rank2' => [],
             'rank3' => [],
             'date' => [],
         ];
         foreach ($list as $object) {
            $return['rank0'][] = $object->getChartRank0();
            $return['rank1'][] = $object->getChartRank1();
            $return['rank2'][] = $object->getChartRank2();
            $return['rank3'][] = $object->getChartRank3();
            $return['date'][] = $object->getDate();
         }
         return $return;
    }
}
