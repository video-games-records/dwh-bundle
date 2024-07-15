<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\Creator;

use Datetime;
use DateInterval;
use Exception;
use VideoGamesRecords\DwhBundle\Contracts\DwhInterface;
use VideoGamesRecords\DwhBundle\DataProvider\TopProvider;
use VideoGamesRecords\DwhBundle\Traits\Top\GetHtmlTopTrait;

class TopCreator implements DwhInterface
{
    use GetHtmlTopTrait;

    protected TopProvider $topProvider;
    protected string $interval;
    protected int $nbElement;

    public function __construct(
        TopProvider $topProvider,
        string $interval,
        int $nbElement
    ) {
        $this->topProvider = $topProvider;
        $this->interval = $interval;
        $this->nbElement = $nbElement;
    }

    /**
     * @param $day
     * @return string[]
     * @throws Exception
     */
    public function handle($day): array
    {
        $date1Begin = new DateTime($day);
        $date1End = new DateTime($day);

        $date1End->sub(new DateInterval('P1D'));
        $date1Begin->sub(new DateInterval($this->interval));

        $date2Begin = clone($date1Begin);
        $date2End = clone($date1End);

        $date2Begin->sub(new DateInterval($this->interval));
        $date2End->sub(new DateInterval($this->interval));


        $gamesData = $this->topProvider->getStrategy(self::TYPE_GAME)
            ->getTop($date1Begin, $date1End, $date2Begin, $date2End, $this->nbElement);
        $gamesHtmlEn = $this->getHtmlTopGame($gamesData);
        $gamesHtmlFr = $this->getHtmlTopGame($gamesData, 'fr');

        $playersData = $this->topProvider->getStrategy(self::TYPE_PLAYER)
            ->getTop($date1Begin, $date1End, $date2Begin, $date2End, $this->nbElement);
        $playersHtmlEn = $this->getHtmlTopPlayer($playersData);
        $playersHtmlFr = $this->getHtmlTopPlayer($playersData, 'fr');

        $textEn = $gamesHtmlEn . '<br /><br />' . $playersHtmlEn;
        $textFr = $gamesHtmlFr . '<br /><br />' . $playersHtmlFr;

        return [
            'fr' => $textFr,
            'en' => $textEn
        ];
    }
}
