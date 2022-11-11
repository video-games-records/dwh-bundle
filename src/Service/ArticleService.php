<?php
namespace VideoGamesRecords\DwhBundle\Service;

use DateInterval;
use DateTime;
use Exception;
use ProjetNormandie\ArticleBundle\Service\Writer;

class ArticleService
{
    private TopGameProvider $topGameProvider;
    private TopPlayerProvider $topPlayerProvider;
    private Writer $writer;

    public function __construct(
        TopGameProvider $topGameProvider,
        TopPlayerProvider $topPlayerProvider,
        Writer $writer
    ) {
        $this->topGameProvider = $topGameProvider;
        $this->topPlayerProvider = $topPlayerProvider;
        $this->writer = $writer;
    }

    /**
     * @param $day
     * @throws Exception
     */
    public function postTopWeek($day): void
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

        $gamesData  = $this->topGameProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData, 'en');
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');

        $playersData  = $this->topPlayerProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 20);
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
            )
        );
    }


    /**
     * @param $day
     * @throws Exception
     */
    public function postTopMonth($day): void
    {
        $date1Begin = new DateTime($day);
        $date1End = new DateTime($day);

        $date1End->sub(new DateInterval('P1D'));
        $date1Begin->sub(new DateInterval('P1M'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new DateInterval('P1M'));
        $date2End->sub(new DateInterval('P1M'));

        $month = $date1Begin->format('F');

        $gamesData  = $this->topGameProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData, 'en');
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');

        $playersData  = $this->topPlayerProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 50);
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
            )
        );
    }


     /**
     * @param $day
     * @throws Exception
     */
    public function postTopYear($day): void
    {
        $date1Begin = new DateTime($day);
        $date1End = new DateTime($day);

        $date1End->sub(new DateInterval('P1D'));
        $date1Begin->sub(new DateInterval('P1Y'));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new DateInterval('P1Y'));
        $date2End->sub(new DateInterval('P1Y'));

        $year = $date1Begin->format('Y');

        $gamesData  = $this->topGameProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 100);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData, 'en');
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');


        $playersData  = $this->topPlayerProvider->getTop($date1Begin, $date1End, $date2Begin, $date2End, 100);
        $playersHtmlEn = $this->getHtmlTopPlayer($playersData, 'en');
        $playersHtmlFr = $this->getHtmlTopPlayer($playersData, 'fr');

        $textEn = $gamesHtmlEn . '<br /><br />' . $playersHtmlEn;
        $textFr = $gamesHtmlFr . '<br /><br />' . $playersHtmlFr;

        $this->writer->write(
            array(
                'en' => 'Top of year #' . $year,
                'fr' => 'Top de l\'année #' . $year,
            ),
            array(
                'en' => $textEn,
                'fr' => $textFr,
            )
        );
    }


    /**
     * @param        $data
     * @param string $locale
     * @return string
     */
    public function getHtmlTopPlayer($data, string $locale = 'en'): string
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div class="article-top article-top__players">';
            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img src="%s" alt="%s" class="article-top__player" /></a>',
                        '/' . $locale . '/' . $data['list'][$i]['player']->getUrl(),
                        'https://picture.video-games-records.com/user/' . $data['list'][$i]['player']->getAvatar(),
                        $data['list'][$i]['player']->getPseudo()
                    );
                }
                if ($i == 0) {
                    $html .= '<br />';
                }
            }
            
            $html .= '<table class="article-top__table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th scope="col"><abbr title="Rank">#</abbr></th>';
            $html .= '<th scope="col">Player</th>';
            $html .= '<th scope="col">Posts submitted</th>';
            $html .= '<th scope="col">Position change</th>';
            $html .= '</tr>';
            $html .= '</tr>';
            $html .= '<tbody>';

            foreach ($data['list'] as $row) {
                $html .= sprintf(
                    $this->getHtmLine(),
                    $row['rank'],
                    '/' . $locale . '/' . $row['player']->getUrl(),
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
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * @param        $data
     * @param string $locale
     * @return string
     */
    private function getHtmlTopGame($data, string $locale = 'en'): string
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div class="article-top article-top__games">';

            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img src="%s" alt="%s" class="article-top__game" /></a>',
                        '/' . $locale . '/' . $data['list'][$i]['game']->getUrl(),
                        'https://picture.video-games-records.com/game/' . $data['list'][$i]['game']->getPicture(),
                        $data['list'][$i]['game']->getName()
                    );
                }
                if ($i == 0) {
                    $html .= '<br />';
                }
            }

            $html .= '<table class="article-top__table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th scope="col"><abbr title="Rank">#</abbr></th>';
            $html .= '<th scope="col">Game</th>';
            $html .= '<th scope="col">Posts submitted</th>';
            $html .= '<th scope="col">Position change</th>';
            $html .= '</tr>';
            $html .= '</tr>';
            $html .= '<tbody>';

            foreach ($data['list'] as $row) {
                $html .= sprintf(
                    $this->getHtmLine(),
                    $row['rank'],
                    '/' . $locale . '/' . $row['game']->getUrl(),
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
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * @param $row
     * @param $nbGame
     * @return string
     */
    private function diff($row, $nbGame): string
    {
        if ($row['oldRank'] != null) {
            if ($row['rank'] < $row['oldRank']) {
                if ($row['oldRank'] > $nbGame) {
                    $col = '<span class="article-top--new"><abbr title="New">N</abbr></span>';
                } else {
                    $col = sprintf('<span class="article-top--up">+%d <span class="screen-reader-text">position</span></span>', $row['oldRank'] - $row['rank']);
                }
            } elseif ($row['rank'] > $row['oldRank']) {
                $col = sprintf('<span class="article-top--down">-%d <span class="screen-reader-text">position</span></span>', $row['rank'] - $row['oldRank']);
            } else {
                $col = '<span class="article-top--equal"><abbr title="Same position">=</abbr></span>';
            }
        } else {
            $col = '<span class="article-top--new"><abbr title="New">N</abbr></span>';
        }
        return $col;
    }


    /**
     * @return string
     */
    private function getHtmLine(): string
    {
        return '
            <tr>
                <td>%d</td>
                <td>
		            <a href="%s">%s</a>
	            </td>
	            <td>%s posts</td>
	            <td>
	                %s
	            </td>
	        </tr>';
    }

    /**
     * @return string
     */
    private function getHtmlBottom1(): string
    {
        return '
            <tr>
                <td colspan="2" class="article-top__bottom-left">%d - %d</td>
                <td colspan="2" class="article-top__bottom-right">%d posts</td>
            </tr>';
    }

    /**
     * @return string
     */
    private function getHtmlBottom2(): string
    {
        return '
            <tfooter>
                <tr>
                    <th scope="row" colspan="2" class="article-top__bottom-left">Total</th>
                    <td colspan="2" class="article-top__bottom-right">%d posts</td>
                </tr>
            </tfooter>';
    }
}