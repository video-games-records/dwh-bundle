<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use ProjetNormandie\ArticleBundle\Service\Writer;
use VideoGamesRecords\DwhBundle\Service\Game as GameService;
use VideoGamesRecords\DwhBundle\Service\Player as PlayerService;

class Article
{
    private $dwhEntityManager;
    private $defaultEntityManager;
    private $gameService;
    private $playerService;
    private $writer;

    public function __construct(
        EntityManager $dwhEntityManager,
        EntityManager $defaultEntityManager,
        GameService $gameService,
        PlayerService $playerService,
        Writer $writer
    ) {
        $this->dwhEntityManager = $dwhEntityManager;
        $this->defaultEntityManager = $defaultEntityManager;
        $this->gameService = $gameService;
        $this->playerService = $playerService;
        $this->writer = $writer;
    }

    /**
     * @param $day
     * @throws Exception
     */
    public function postTopWeek($day)
    {
        $date1Begin = new DateTime($day);
        $date1End = new DateTime($day);

        $date1End->sub(new DateInterval('P1D'));
        $date1Begin->sub(new DateInterval('P7D'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new DateInterval('P7D'));
        $date2End->sub(new DateInterval('P7D'));

        $week = $date1Begin->format('W');

        $gamesData  = $this->gameService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData, 'en');
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');

        $playersData  = $this->playerService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
        $playersHtmlEn = $this->getHtmlTopPlayer($playersData, 'en');
        $playersHtmlFr = $this->getHtmlTopPlayer($playersData, 'fr');

        $textEn = $gamesHtmlEn . '<br /><br />' . $playersHtmlEn;
        $textFr = $gamesHtmlFr . '<br /><br />' . $playersHtmlFr;

        $this->writer->write(
            array(
                'en' => 'Top of week #' . $week,
                'fr' => 'Top de la semaine #' . $week,
            ),
            array(
                'en' => $textEn,
                'fr' => $textFr,
            ),
            $this->defaultEntityManager->getReference('VideoGamesRecords\CoreBundle\Entity\User\UserInterface', 1)
        );
    }


    /**
     * @param $day
     * @throws Exception
     */
    public function postTopMonth($day)
    {
        $date1Begin = new DateTime($day);
        $date1End = new DateTime($day);

        $date1End->sub(new DateInterval('P1D'));
        $date1Begin->sub(new DateInterval('P1M'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new DateInterval('P1M'));
        $date2End->sub(new DateInterval('P1M'));


        /*echo $date1Begin->format('Y-m-d') . "\n";
        echo $date1End->format('Y-m-d') . "\n";
        echo $date2Begin->format('Y-m-d') . "\n";
        echo $date2End->format('Y-m-d') . "\n";*/


        $month = $date1Begin->format('F');

        $gamesData  = $this->gameService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData, 'en');
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');

        $playersData  = $this->playerService->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
        $playersHtmlEn = $this->getHtmlTopPlayer($playersData, 'en');
        $playersHtmlFr = $this->getHtmlTopPlayer($playersData, 'fr');

        $textEn = $gamesHtmlEn . '<br /><br />' . $playersHtmlEn;
        $textFr = $gamesHtmlFr . '<br /><br />' . $playersHtmlFr;

        $this->writer->write(
            array(
                'en' => 'Top of month #' . $month,
                'fr' => 'Top du mois #' . $month,
            ),
            array(
                'en' => $textEn,
                'fr' => $textFr,
            ),
            $this->defaultEntityManager->getReference('VideoGamesRecords\CoreBundle\Entity\User\UserInterface', 1)
        );
    }


    /**
     * @param        $data
     * @param string $locale
     * @return string
     */
    public function getHtmlTopPlayer($data, $locale = 'en')
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div align="center">';
            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img hspace="10" src="%s" alt="%s" /></a>',
                        '#/' . $locale . '/' . $data['list'][$i]['player']->getUrl(),
                        'https://picture.video-games-records.com/user/' . $data['list'][$i]['player']->getAvatar(),
                        $data['list'][$i]['player']->getPseudo()
                    );
                }
                if ($i == 0) {
                    $html .= '<br />';
                }
            }
            $html .= '</div>';
            $html .= '<br />';
            $html .= '<table border="0">';
            $html .= '<tbody>';

            foreach ($data['list'] as $row) {
                $html .= sprintf(
                    $this->getHtmLine(),
                    $row['rank'],
                    '#/' . $locale . '/' . $row['player']->getUrl(),
                    (($row['player'] != null) ? $row['player']->getPseudo() : '???'),
                    $row['nb'],
                    $this->diff($row, count($data['list']))
                );
            }

            if ($data['nbTotalPost'] > $data['nbPostFromList']) {
                $html .= sprintf(
                    $this->getHtmlBottom1(),
                    count($data['list']) + 1,
                    $data['nb'],
                    $data['nbTotalPost'] - $data['nbPostFromList']
                );
            }
            $html .= sprintf($this->getHtmlBottom2(), $data['nbTotalPost']);
            $html .= '</tbody>';
            $html .= '</table>';
        }

        return $html;
    }

    /**
     * @param        $data
     * @param string $locale
     * @return string
     */
    private function getHtmlTopGame($data, $locale = 'en')
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div align="center">';

            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img hspace="10" src="%s" alt="%s" /></a>',
                        '#/' . $locale . '/' . $data['list'][$i]['game']->getUrl(),
                        'https://picture.video-games-records.com/game/' . $data['list'][$i]['game']->getPicture(),
                        $data['list'][$i]['game']->getName()
                    );
                }
                if ($i == 0) {
                    $html .= '<br />';
                }
            }
            $html .= '</div>';
            $html .= '<br />';
            $html .= '<table border="0">';
            $html .= '<tbody>';

            foreach ($data['list'] as $row) {
                $html .= sprintf(
                    $this->getHtmLine(),
                    $row['rank'],
                    '#/' . $locale . '/' . $row['game']->getUrl(),
                    $row['game']->getName(),
                    $row['nb'],
                    $this->diff($row, count($data['list']))
                );
            }
            if ($data['nbTotalPost'] > $data['nbPostFromList']) {
                $html .= sprintf(
                    $this->getHtmlBottom1(),
                    count($data['list']) + 1,
                    $data['nbItem'],
                    $data['nbTotalPost'] - $data['nbPostFromList']
                );
            }
            $html .= sprintf($this->getHtmlBottom2(), $data['nbTotalPost']);
            $html .= '</tbody>';
            $html .= '</table>';
        }

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
