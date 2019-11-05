<?php
namespace VideoGamesRecords\DwhBundle\Service;

use VideoGamesRecords\DwhBundle\Entity\Player as DwhPlayer;

class Player
{
    private $dwhEntityManager;
    private $defaultEntityManager;
    private $playerRepository;

    public function __construct(\Doctrine\ORM\EntityManager $dwhEntityManager, \Doctrine\ORM\EntityManager $defaultEntityManager)
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
        $date1 = new \DateTime();
        $date1->sub(new \DateInterval('P1D'));
        $date2 = new \DateTime();

        $data1 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Player')->getNbPostDay($date1, $date2);

        $data2 = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:PlayerChart')->getDataRank();

        $list = $this->defaultEntityManager->getRepository('VideoGamesRecordsCoreBundle:Player')->getDataForDwh();

        foreach ($list as $row) {
            $idPlayer = $row['idPlayer'];
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
        $date = new \DateTime();
        $date = $date->sub(\DateInterval::createFromDateString('3 years'));

        //----- delete
        $query = $this->dwhEntityManager->createQuery('DELETE VideoGamesRecords\DwhBundle\Entity\Player p WHERE p.date < :date');
        $query->setParameter('date', $date->format('Y-m-d'));
        $query->execute();
    }

    /**
     * @param \DateTime $beginA
     * @param \DateTime $endA
     * @param \DateTime $beginB
     * @param \DateTime $endB
     * @param integer $limit
     *
     * @return array
     */
    public function getTop($beginA, $endA, $beginB, $endB, $limit)
    {
        $playerListA = $this->playerRepository->getTop($beginA, $endA, $limit);
        $playerListB = $this->playerRepository->getTop($beginB, $endB, $limit);

        // Get old rank
        $oldRank = array();
        foreach ($playerListB as $key => $row) {
            $oldRank[$row['idPlayer']] = $key + 1;
        }

        $nbPostFromList = 0;
        for ($i=0, $nb=count($playerListA) - 1; $i <= $nb; ++$i) {
            $idPlayer = $playerListA[$i]['idPlayer'];
            if (isset($oldRank[$idPlayer])) {
                $playerListA[$i]['oldRank'] = $oldRank[$idPlayer];
            } else {
                $playerListA[$i]['oldRank'] = null;
            }

            $nbPostFromList += $playerListA[$i]['nb'];
        }

        $nbPlayer = $this->playerRepository->getTotalNbPlayer($beginA, $endA);
        $nbTotalPost = $this->playerRepository->getTotalNbPostDay($beginA, $endA);

        $playerList = \VideoGamesRecords\CoreBundle\Tools\Ranking::addRank(
            $playerListA,
            'rank',
            ['nb'],
            true
        );

        return array(
            'playerList' => $playerList,
            'nbPostFromList' => $nbPostFromList,
            'nbPlayer' => $nbPlayer,
            'nbTotalPost' => $nbTotalPost,
        );
    }

    /**
     * @param \DateTime $beginA
     * @param \DateTime $endA
     * @param \DateTime $beginB
     * @param \DateTime $endB
     * @param integer $limit
     *
     * @return string
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
        foreach ($top['playerList'] as $row) {
            $html .= sprintf($line, $row['rank'], 'URL', $row['idPlayer'], $row['nb'], $this->diff($row, count($top['playerList'])));
        }

        if ($top['nbTotalPost'] > $top['nbPostFromList']) {
            $html .= sprintf($bottom1, count($top['playerList']) + 1, $top['nbGame'], $top['nbTotalPost'] - $top['nbPostFromList']);
        }
        $html .= sprintf($bottom2, $top['nbTotalPost']);
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    /**
     * @param $row
     * @param $nbPlayer
     * @return string
     */
    private function diff($row, $nbPlayer)
    {
        if ($row['oldRank'] !== null) {
            if ($row['rank'] < $row['oldRank']) {
                if ($row['oldRank'] > $nbPlayer) {
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
