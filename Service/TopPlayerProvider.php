<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository as DwhPlayerRepository;
use VideoGamesRecords\CoreBundle\Repository\PlayerRepository as CorePlayerRepository;

class TopPlayerProvider
{
    private EntityManagerInterface $dwhEntityManager;
    private EntityManagerInterface $defaultEntityManager;

    public function __construct(EntityManagerInterface $dwhEntityManager, EntityManagerInterface $defaultEntityManager)
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
    }

    /**
     * @param DateTime $date1Begin
     * @param DateTime $date1End
     * @param DateTime $date2Begin
     * @param DateTime $date2End
     * @param integer  $limit
     * @return array
     */
    public function getTop(DateTime $date1Begin, DateTime $date1End, DateTime $date2Begin, DateTime $date2End, int $limit = 20): array
    {
        /** @var DwhPlayerRepository $dwhPlayerRepository */
        $dwhPlayerRepository = $this->dwhEntityManager->getRepository('VideoGamesRecords\DwhBundle\Entity\Player');

        /** @var CorePlayerRepository $dwhPlayerRepository */
        $corePlayerRepository = $this->defaultEntityManager->getRepository('VideoGamesRecords\CoreBundle\Entity\Player');

        $playerList1 = $dwhPlayerRepository->getTop(
            $date1Begin,
            $date1End,
            $limit
        );
        $playerList2 = $dwhPlayerRepository->getTop(
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
            $player = $corePlayerRepository->find($idPlayer);
            $playerList1[$i]['player'] = $player;
            $nbPostFromList += $playerList1[$i]['nb'];
        }

        $nbPlayer = 0;
        try {
            $nbPlayer = $dwhPlayerRepository->getTotalNbPlayer($date1Begin, $date1End);
        } catch (NoResultException|NonUniqueResultException $e) {
        }

        $nbTotalPost = 0;
        try {
            $nbTotalPost = $dwhPlayerRepository->getTotalNbPostDay($date1Begin, $date1End);
        } catch (NoResultException|NonUniqueResultException $e) {
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
}
