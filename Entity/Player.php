<?php

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Player
 *
 * @ORM\Table(name="dwh_player")
 * @ORM\Entity(repositoryClass="VideoGamesRecords\DwhBundle\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="date", type="string", length=10, nullable=false)
     * @ORM\Id
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank0", type="integer", nullable=true)
     */
    private $chartRank0 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank1", type="integer", nullable=true)
     */
    private $chartRank1 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank2", type="integer", nullable=true)
     */
    private $chartRank2 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank3", type="integer", nullable=true)
     */
    private $chartRank3 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank4", type="integer", nullable=true)
     */
    private $chartRank4 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank5", type="integer", nullable=true)
     */
    private $chartRank5 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank6", type="integer", nullable=true)
     */
    private $chartRank6 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank7", type="integer", nullable=true)
     */
    private $chartRank7 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank8", type="integer", nullable=true)
     */
    private $chartRank8 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank9", type="integer", nullable=true)
     */
    private $chartRank9 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank10", type="integer", nullable=true)
     */
    private $chartRank10 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank11", type="integer", nullable=true)
     */
    private $chartRank11 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank12", type="integer", nullable=true)
     */
    private $chartRank12 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank13", type="integer", nullable=true)
     */
    private $chartRank13 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank14", type="integer", nullable=true)
     */
    private $chartRank14 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank15", type="integer", nullable=true)
     */
    private $chartRank15 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank16", type="integer", nullable=true)
     */
    private $chartRank16 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank17", type="integer", nullable=true)
     */
    private $chartRank17 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank18", type="integer", nullable=true)
     */
    private $chartRank18 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank19", type="integer", nullable=true)
     */
    private $chartRank19 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank20", type="integer", nullable=true)
     */
    private $chartRank20 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank21", type="integer", nullable=true)
     */
    private $chartRank21 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank22", type="integer", nullable=true)
     */
    private $chartRank22 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank23", type="integer", nullable=true)
     */
    private $chartRank23 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank24", type="integer", nullable=true)
     */
    private $chartRank24 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank25", type="integer", nullable=true)
     */
    private $chartRank25 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank26", type="integer", nullable=true)
     */
    private $chartRank26 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank27", type="integer", nullable=true)
     */
    private $chartRank27 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank28", type="integer", nullable=true)
     */
    private $chartRank28 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank29", type="integer", nullable=true)
     */
    private $chartRank29 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartRank30", type="integer", nullable=true)
     */
    private $chartRank30 = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="pointChart", type="integer", nullable=false)
     */
    private $pointChart = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="rankPointChart", type="integer", nullable=true)
     */
    private $rankPointChart;

    /**
     * @var integer
     *
     * @ORM\Column(name="rankMedal", type="integer", nullable=true)
     */
    private $rankMedal;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbChart", type="integer", nullable=false)
     */
    private $nbChart = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="pointGame", type="integer", nullable=false)
     */
    private $pointGame = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="rankPointGame", type="integer", nullable=true)
     */
    private $rankPointGame;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPostDay", type="integer", nullable=false)
     */
    private $nbPostDay = 0;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s [%s]', $this->id, $this->id);
    }

    /**
     * Set id
     * @param integer $id
     * @return Player
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     * @param string $date
     * @return Player
     */
    public function setDate(string $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set chartRank0
     * @param integer $chartRank0
     * @return Player
     */
    public function setChartRank0(int $chartRank0)
    {
        $this->chartRank0 = $chartRank0;

        return $this;
    }

    /**
     * Get chartRank0
     *
     * @return integer
     */
    public function getChartRank0()
    {
        return $this->chartRank0;
    }

    /**
     * Set chartRank1
     * @param integer $chartRank1
     * @return Player
     */
    public function setChartRank1(int $chartRank1)
    {
        $this->chartRank1 = $chartRank1;

        return $this;
    }

    /**
     * Get chartRank1
     *
     * @return integer
     */
    public function getChartRank1()
    {
        return $this->chartRank1;
    }

    /**
     * Set chartRank2
     * @param integer $chartRank2
     * @return Player
     */
    public function setChartRank2(int $chartRank2)
    {
        $this->chartRank2 = $chartRank2;

        return $this;
    }

    /**
     * Get chartRank2
     *
     * @return integer
     */
    public function getChartRank2()
    {
        return $this->chartRank2;
    }

    /**
     * Set chartRank3
     * @param integer $chartRank3
     * @return Player
     */
    public function setChartRank3(int $chartRank3)
    {
        $this->chartRank3 = $chartRank3;

        return $this;
    }

    /**
     * Get chartRank3
     *
     * @return integer
     */
    public function getChartRank3()
    {
        return $this->chartRank3;
    }

    /**
     * Set chartRank
     * @param integer $rank
     * @param integer $nb
     * @return $this
     */
    public function setChartRank(int $rank, int $nb)
    {
        $var = 'chartRank' . $rank;
        $this->$var = $nb;

        return $this;
    }


    /**
     * Get chartRank
     * @param integer $rank
     * @return integer
     */
    public function getChartRank(int $rank)
    {
        $var = 'chartRank' . $rank;
        return $this->$var;
    }

    /**
     * Set pointChart
     * @param integer $pointChart
     * @return Player
     */
    public function setPointChart(int $pointChart)
    {
        $this->pointChart = $pointChart;

        return $this;
    }

    /**
     * Get pointChart
     *
     * @return integer
     */
    public function getPointChart()
    {
        return $this->pointChart;
    }


    /**
     * Set rankPointChart
     * @param integer $rankPointChart
     * @return Player
     */
    public function setRankPointChart(int $rankPointChart)
    {
        $this->rankPointChart = $rankPointChart;

        return $this;
    }

    /**
     * Get rankPointChart
     *
     * @return integer
     */
    public function getRankPointChart()
    {
        return $this->rankPointChart;
    }

    /**
     * Set rankMedal
     * @param integer $rankMedal
     * @return Player
     */
    public function setRankMedal(int $rankMedal)
    {
        $this->rankMedal = $rankMedal;

        return $this;
    }

    /**
     * Get rankMedal
     *
     * @return integer
     */
    public function getRankMedal()
    {
        return $this->rankMedal;
    }


    /**
     * Set nbChart
     * @param integer $nbChart
     * @return Player
     */
    public function setNbChart(int $nbChart)
    {
        $this->nbChart = $nbChart;

        return $this;
    }

    /**
     * Get nbChart
     *
     * @return integer
     */
    public function getNbChart()
    {
        return $this->nbChart;
    }

    /**
     * Set pointGame
     * @param integer $pointGame
     * @return Player
     */
    public function setPointGame(int $pointGame)
    {
        $this->pointGame = $pointGame;

        return $this;
    }

    /**
     * Get pointGame
     *
     * @return integer
     */
    public function getPointGame()
    {
        return $this->pointGame;
    }

    /**
     * Set rankPointGame
     * @param integer $rankPointGame
     * @return Player
     */
    public function setRankPointGame(int $rankPointGame)
    {
        $this->rankPointGame = $rankPointGame;

        return $this;
    }

    /**
     * Get rankPointGame
     *
     * @return integer
     */
    public function getRankPointGame()
    {
        return $this->rankPointGame;
    }

    /**
     * Set nbPostDay
     * @param integer $nbPostDay
     * @return Player
     */
    public function setNbPostDay(int $nbPostDay)
    {
        $this->nbPostDay = $nbPostDay;

        return $this;
    }

    /**
     * Get nbPostDay
     *
     * @return integer
     */
    public function getNbPostDay()
    {
        return $this->nbPostDay;
    }

    /**
     * @param array $row
     */
    public function setFromArray(array $row)
    {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
}
