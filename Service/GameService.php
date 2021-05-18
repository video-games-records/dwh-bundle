<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use VideoGamesRecords\DwhBundle\Entity\Game as DwhGame;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;

class GameService
{
    private $dwhEntityManager;
    private $defaultEntityManager;

    public function __construct(EntityManager $dwhEntityManager, EntityManager $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function maj()
    {
        $date1 = new DateTime();
        $date1->sub(new DateInterval('P1D'));
        $date2 = new DateTime();

        $data1 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Game')->getNbPostDay($date1, $date2);

        $games = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Game')->findAll();

        foreach ($games as $game) {
            $id = $game->getId();
            $object = new DwhGame();
            $object->setDate($date1->format('Y-m-d'));
            $object->setFromArray(
                array(
                    'id' => $game->getId(),
                    'nbPost' => $game->getNbPost(),
                )
            );
            $object->setNbPostDay((isset($data1[$id])) ? $data1[$id] : 0);
            $this->dwhEntityManager->persist($object);
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
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Game g WHERE g.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }

    /**
     * @param $date1Begin
     * @param $date1End
     * @param $date2Begin
     * @param $date2End
     * @param $limit
     * @return array
     */
    public function getTop(DateTime $date1Begin, DateTime $date1End, DateTime $date2Begin, DateTime $date2End, $limit = 20)
    {
        $gameList1 = $this->dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Game')->getTop(
            $date1Begin,
            $date1End,
            $limit
        );
        $gameList2 = $this->dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Game')->getTop(
            $date2Begin,
            $date2End,
            $limit
        );

        // Get old rank
        $oldRank = array();
        foreach ($gameList2 as $key => $row) {
            $oldRank[$row['id']] = $key + 1;
        }

        $nbPostFromList = 0;
        for ($i=0, $nb=count($gameList1) - 1; $i <= $nb; ++$i) {
            $idGame = $gameList1[$i]['id'];
            if (isset($oldRank[$idGame])) {
                $gameList1[$i]['oldRank'] = $oldRank[$idGame];
            } else {
                $gameList1[$i]['oldRank'] = null;
            }

            $game = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Game')->find($idGame);
            $gameList1[$i]['game'] = $game;
            $nbPostFromList += $gameList1[$i]['nb'];
        }

        $nbGame = $this->dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Game')->getTotalNbGame($date1Begin, $date1End);
        $nbTotalPost = $this->dwhEntityManager->getRepository('VideoGamesRecordsDwhBundle:Game')->getTotalNbPostDay($date1Begin, $date1End);

        $gameList = ToolsRanking::addRank(
            $gameList1,
            'rank',
            ['nb'],
            true
        );

        return array(
            'list' => $gameList,
            'nbPostFromList' => $nbPostFromList,
            'nbItem' => $nbGame,
            'nbTotalPost' => $nbTotalPost,
        );
    }
}
