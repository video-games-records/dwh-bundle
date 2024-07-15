<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Traits\Top;

trait GetHtmlTopTrait
{
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
                        '<a href="%s"><img src="https://backoffice.video-games-records.com/game/%d/picture" alt="%s" class="article-top__game" /></a>',
                        '/' . $locale . '/' . $data['list'][$i]['game']->getUrl(),
                        $data['list'][$i]['game']->getId(),
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
     * @param        $data
     * @param string $locale
     * @return string
     */
    private function getHtmlTopPlayer($data, string $locale = 'en'): string
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div class="article-top article-top__players">';
            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img src="https://backoffice.video-games-records.com/users/%d/avatar" alt="%s" class="article-top__player" /></a>',
                        '/' . $locale . '/' . $data['list'][$i]['player']->getUrl(),
                        $data['list'][$i]['player']->getId(),
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
                    $col = sprintf(
                        '<span class="article-top--up">+%d <span class="screen-reader-text">position</span></span>',
                        $row['oldRank'] - $row['rank']
                    );
                }
            } elseif ($row['rank'] > $row['oldRank']) {
                $col = sprintf(
                    '<span class="article-top--down">-%d <span class="screen-reader-text">position</span></span>',
                    $row['rank'] - $row['oldRank']
                );
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
