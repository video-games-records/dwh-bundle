<?php
namespace VideoGamesRecords\DwhBundle\Service;

use VideoGamesRecords\DwhBundle\Repository\GameRepository;

class Game
{
    private $repository;

    public function __construct(GameRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DateTime $beginA
     * @param DateTime $endA
     * @param DateTime $beginB
     * @param DateTime $endB
     * @param integer $limit
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return array
     */
    public function getTop($beginA, $endA, $beginB, $endB, $limit)
    {
        $gameListA = $this->repository->getTop($beginA, $endA, $limit);
        $gameListB = $this->repository->getTop($beginB, $endB, $limit);

        // Get old rank
        $oldRank = array();
        foreach ($gameListB as $key => $row) {
            $oldRank[$row['id']] = $key + 1;
        }

        $nbPostFromList = 0;
        for ($i=0, $nb=count($gameListA) - 1; $i <= $nb; ++$i) {
            $idGame = $gameListA[$i]['id'];
            if (isset($oldRank[$idGame])) {
                $gameListA[$i]['oldRank'] = $oldRank[$idGame];
            } else {
                $gameListA[$i]['oldRank'] = null;
            }

            $nbPostFromList += $gameListA[$i]['nb'];
        }

        $nbGame = $this->repository->getTotalNbGame($beginA, $endA);
        $nbTotalPost = $this->repository->getTotalNbPostDay($beginA, $endA);

        $gameList = \VideoGamesRecords\CoreBundle\Tools\Ranking::addRank(
            $gameListA,
            'rank',
            ['nb'],
            true
        );

        return array(
            'gameList' => $gameList,
            'nbPostFromList' => $nbPostFromList,
            'nbGame' => $nbGame,
            'nbTotalPost' => $nbTotalPost,
        );
    }

    /**
     * @param DateTime $beginA
     * @param DateTime $endA
     * @param DateTime $beginB
     * @param DateTime $endB
     * @param integer $limit
     * @return string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getHtmlTop($beginA, $endA, $beginB, $endB, $limit)
    {
        $top = $this->getTop($beginA, $endA, $beginB, $endB, $limit);

        $html = '<table border="0">';
        $html .= '<tbody>';


        $line = '
            <tr>
                <td align="center">%d</td>
                <td class="center" width="344">
		            <a href="%s">%s</a>
	            </td>
	            <td width="82" align="right">%s posts</td>
	            <td width="40" align="center">
	             %s
	            </td>
	        </tr>';

        $bottom1 = '
            <tr>
                <td align="right">%d - %d</td>
                <td width="334"></td>
                <td width="82" align="right">%d posts</td>
                <td></td>
            </tr>';

        $bottom2 = '  
            <tr>
                <td align="right">Total</td>
                <td width="334"></td>
                <td width="82" align="right">%d posts</td>
                <td></td>
            </tr>';

        foreach ($top['gameList'] as $row) {
            $html .= sprintf($line, $row['rank'], 'URL', $row['id'], $row['nb'], $this->diff($row, count($top['gameList'])));
        }
        if ($top['nbTotalPost'] > $top['nbPostFromList']) {
            $html .= sprintf($bottom1, count($top['gameList']) + 1, $top['nbGame'], $top['nbTotalPost'] - $top['nbPostFromList']);
        }
        $html .= sprintf($bottom2, $top['nbTotalPost']);
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    /**
     * @param $row
     * @param $nbGame
     * @return string
     */
    private function diff($row, $nbGame)
    {
        if ($row['oldRank'] != null) {
            if ($row['rank'] < $row['oldRank']) {
                if ($row['oldRank'] > $nbGame) {
                    $col = '<div class="blue">(N)</div>';
                } else {
                    $col = sprintf('<div class="green">(+%d)</div>', $row['oldRank'] - $row['rank']);
                }
            } elseif ($row['rank'] > $row['oldRank']) {
                $col = sprintf('<div class="red">(-%d)</div>', $row['rank'] - $row['oldRank']);
            } else {
                $col = '<div class="grey">(=)</div>';
            }
        } else {
            $col = '<div class="blue">(N)</div>';
        }
        return $col;
    }
}
