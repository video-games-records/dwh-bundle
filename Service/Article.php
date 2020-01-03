<?php
namespace VideoGamesRecords\DwhBundle\Service;

use ProjetNormandie\ArticleBundle\Entity\Article as PnArticle;

class Article
{
    private $dwhEntityManager;
    private $defaultEntityManager;
    private $gameService;
    private $playerService;

    public function __construct(
        \Doctrine\ORM\EntityManager $dwhEntityManager,
        \Doctrine\ORM\EntityManager $defaultEntityManager,
        \VideoGamesRecords\DwhBundle\Service\Game $gameService,
        \VideoGamesRecords\DwhBundle\Service\Player $playerService
    )
    {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
        $this->gameService = $gameService;
        $this->playerService = $playerService;
    }

    /**
     * @param $day
     * @throws \Exception
     */
    public function postTopWeek($day)
    {
        $day = '2017-01-01';
        $date1Begin = new \DateTime($day);
        $date1End = new \DateTime($day);

        $date1End->sub(new \DateInterval('P1D'));
        $date1Begin->sub(new \DateInterval('P7D'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new \DateInterval('P7D'));
        $date2End->sub(new \DateInterval('P7D'));

        $week = $date1Begin->format('W');

        $gamesData  = $this->gameService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
        $gamesHtml = $this->getHtmlTopGame($gamesData);

        $playersData  = $this->playerService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
        $playersHtml = $this->getHtmlTopPlayer($playersData);


        $text = $gamesHtml . '<br /><br />' . $playersHtml;

        $article = new PnArticle();
        $article->translate('en', false)->setTitle('Top of week #' . $week);
        $article->translate('en', false)->setText($text);
        $article->translate('fr', false)->setTitle('Top de la semaine #' . $week);
        $article->translate('fr', false)->setText($text);


        //$article->setAuthor($user);
        $article->mergeNewTranslations();
        $this->defaultEntityManager->persist($article);
        $this->defaultEntityManager->flush();
    }


    /**
     * @param $day
     * @throws \Exception
     */
    public function postTopMonth($day)
    {
        $date1Begin = new \DateTime($day);
        $date1End = new \DateTime($day);

        $date1End->sub(new \DateInterval('P1D'));
        $date1Begin->sub(new \DateInterval('P1M'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new \DateInterval('P1M'));
        $date2End->sub(new \DateInterval('P1M'));


        echo $date1Begin->format('Y-m-d') . "\n";
        echo $date1End->format('Y-m-d') . "\n";
        echo $date2Begin->format('Y-m-d') . "\n";
        echo $date2End->format('Y-m-d') . "\n";


        $month = $date1Begin->format('F');

        $gamesData  = $this->gameService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
        $gamesHtml = $this->getHtmlTopGame($gamesData);

        $playersData  = $this->playerService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
        $playersHtml = $this->getHtmlTopPlayer($playersData);


        $text = $gamesHtml . '<br /><br />' . $playersHtml;

        $article = new PnArticle();
        $article->translate('en', false)->setTitle('Top of month #' . $month);
        $article->translate('en', false)->setText($text);
        $article->translate('fr', false)->setTitle('Top du mois #' . $month);
        $article->translate('fr', false)->setText($text);


        $article->setAuthor(1);
        $article->mergeNewTranslations();
        $this->defaultEntityManager->persist($article);
        $this->defaultEntityManager->flush();
    }


    /**
     * @param $data
     * @return string
     */
    public function getHtmlTopPlayer($data)
    {
        $html = '';

        $html .= '<div align="center">';
        for ($i =0; $i<= 2; $i++) {
            $html .= sprintf(
                '<a href="%s"><img hspace="10" src="%s" alt="%s" /></a>',
                '',
                'https://picture.video-games-records.com/avatar/' . $data['list'][$i]['player']->getAvatar(),
                $data['list'][$i]['player']->getPseudo()
            );
            if ($i == 0) {
                $html .= '<br />';
            }
        }
        $html .= '</div>';
        $html .= '<br />';
        $html .= '<table border="0">';
        $html .= '<tbody>';

        foreach ($data['list'] as $row) {
            $html .= sprintf($this->getHtmLine(), $row['rank'], 'URL', (($row['player'] != null) ? $row['player']->getPseudo() : '???'), $row['nb'], $this->diff($row, count($data['list'])));
        }

        if ($data['nbTotalPost'] > $data['nbPostFromList']) {
            $html .= sprintf($this->getHtmlBottom1(), count($data['list']) + 1, $data['nb'], $data['nbTotalPost'] - $data['nbPostFromList']);
        }
        $html .= sprintf($this->getHtmlBottom2(), $data['nbTotalPost']);
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    /**
     * @param $data
     * @return string
     */
    private function getHtmlTopGame($data)
    {
        $html = '';

        $html .= '<div align="center">';
        for ($i =0; $i<= 2; $i++) {
            $html .= sprintf(
                '<a href="%s"><img hspace="10" src="%s" alt="%s" /></a>',
                '',
                'https://picture.video-games-records.com/jeu/' . $data['list'][$i]['game']->getPicture(),
                $data['list'][$i]['game']->getName()
            );
            if ($i == 0) {
                $html .= '<br />';
            }
        }
        $html .= '</div>';
        $html .= '<br />';
        $html .= '<table border="0">';
        $html .= '<tbody>';

        foreach ($data['list'] as $row) {
            $html .= sprintf($this->getHtmLine(), $row['rank'], 'URL', $row['game']->getName(), $row['nb'], $this->diff($row, count($data['list'])));
        }
        if ($data['nbTotalPost'] > $data['nbPostFromList']) {
            $html .= sprintf($this->getHtmlBottom1(), count($data['list']) + 1, $data['nbItem'], $data['nbTotalPost'] - $data['nbPostFromList']);
        }
        $html .= sprintf($this->getHtmlBottom2(), $data['nbTotalPost']);
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


    /**
     * @return string
     */
    private function getHtmLine()
    {
        return '
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
    }

    /**
     * @return string
     */
    private function getHtmlBottom1()
    {
        return  '
            <tr>
                <td align="right">%d - %d</td>
                <td width="334"></td>
                <td width="82" align="right">%d posts</td>
                <td></td>
            </tr>';
    }

    /**
     * @return string
     */
    private function getHtmlBottom2()
    {
        return '  
            <tr>
                <td align="right">Total</td>
                <td width="334"></td>
                <td width="82" align="right">%d posts</td>
                <td></td>
            </tr>';
    }
}
