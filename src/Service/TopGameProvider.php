<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;
use VideoGamesRecords\DwhBundle\Repository\GameRepository as DwhGameRepository;
use VideoGamesRecords\CoreBundle\Repository\GameRepository as CoreGameRepository;

class TopGameProvider
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
     * @param int      $limit
     * @return array
     */
    public function getTop(DateTime $date1Begin, DateTime $date1End, DateTime $date2Begin, DateTime $date2End, int $limit = 20): array
    {
        /** @var DwhGameRepository $dwhGameRepository */
        $dwhGameRepository = $this->dwhEntityManager->getRepository('VideoGamesRecords\DwhBundle\Entity\Game');

        /** @var CoreGameRepository $coreGameRepository */
        $coreGameRepository = $this->defaultEntityManager->getRepository('VideoGamesRecords\CoreBundle\Entity\Game');

        $gameList1 = $dwhGameRepository->getTop(
            $date1Begin,
            $date1End,
            $limit
        );
        $gameList2 = $dwhGameRepository->getTop(
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
        for ($i = 0, $nb = count($gameList1) - 1; $i <= $nb; ++$i) {
            $idGame = $gameList1[$i]['id'];
            if (isset($oldRank[$idGame])) {
                $gameList1[$i]['oldRank'] = $oldRank[$idGame];
            } else {
                $gameList1[$i]['oldRank'] = null;
            }

            $game = $coreGameRepository->find($idGame);
            $gameList1[$i]['game'] = $game;
            $nbPostFromList += $gameList1[$i]['nb'];
        }

        $nbGame = 0;
        try {
            $nbGame = $dwhGameRepository->getTotalNbGame($date1Begin, $date1End);
        } catch (NoResultException | NonUniqueResultException $e) {
        }
        $nbTotalPost = 0;
        try {
            $nbTotalPost = $dwhGameRepository->getTotalNbPostDay($date1Begin, $date1End);
        } catch (NoResultException | NonUniqueResultException $e) {
        }

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
