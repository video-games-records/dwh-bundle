<?php
namespace VideoGamesRecords\DwhBundle\DataProvider\Strategy\Top;

use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use VideoGamesRecords\CoreBundle\Repository\PlayerRepository as CorePlayerRepository;
use VideoGamesRecords\CoreBundle\Tools\Ranking as ToolsRanking;
use VideoGamesRecords\DwhBundle\Contracts\Strategy\TopStrategyInterface;
use VideoGamesRecords\DwhBundle\Repository\PlayerRepository as DwhPlayerRepository;

class TopPlayerStrategy extends AbstractTopProvider implements TopStrategyInterface
{
    public function supports(string $name): bool
    {
        return $name == self::TYPE_PLAYER;
    }

    /**
     * @param DateTime $date1Begin
     * @param DateTime $date1End
     * @param DateTime $date2Begin
     * @param DateTime $date2End
     * @param integer  $limit
     * @return array
     */
    public function getTop(
        DateTime $date1Begin,
        DateTime $date1End,
        DateTime $date2Begin,
        DateTime $date2End,
        int $limit = 20
    ): array
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
        for ($i = 0, $nb = count($playerList1) - 1; $i <= $nb; ++$i) {
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

        try {
            $nbPlayer = $dwhPlayerRepository->getTotalNbPlayer($date1Begin, $date1End);
        } catch (NoResultException | NonUniqueResultException $e) {
            // OK
        }

        try {
            $nbTotalPost = $dwhPlayerRepository->getTotalNbPostDay($date1Begin, $date1End);
        } catch (NoResultException | NonUniqueResultException $e) {
            // OK
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
