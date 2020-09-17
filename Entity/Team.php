<?php

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="dwh_team", indexes={@ORM\Index(name="idxTeam", columns={"idTeam"}), @ORM\Index(name="idxDate", columns={"date"})})
 * @ORM\Entity(repositoryClass="VideoGamesRecords\DwhBundle\Repository\TeamRepository")
 */
class Team
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
     * @ORM\Column(name="rankBadge", type="integer", nullable=true)
     */
    private $rankBadge;

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
     * @var integer
     *
     * @ORM\Column(name="pointBadge", type="integer", nullable=false)
     */
    private $pointBadge = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbMasterBadge", type="integer", nullable=false)
     */
    private $nbMasterBadge = 0;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s [%s]', $this->idTeam, $this->idTeam);
    }

    /**
     * Set id
     * @param integer $id
     * @return Team
     */
    public function setId(int $id)
    {
        $this->id= $id;
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * Set rankBadge
     * @param integer $rankBadge
     * @return Team
     */
    public function setRankBadge(int $rankBadge)
    {
        $this->rankBadge = $rankBadge;

        return $this;
    }

    /**
     * Get rankBadge
     *
     * @return integer
     */
    public function getRankBadge()
    {
        return $this->rankBadge;
    }

    /**
     * Set pointGame
     * @param integer $pointGame
     * @return Team
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
     * @return Team
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
     * @return Team
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
     * Set pointBadge
     * @param integer $pointBadge
     * @return Team
     */
    public function setNPointBadge(int $pointBadge)
    {
        $this->pointBadge = $pointBadge;

        return $this;
    }

    /**
     * Get pointBadge
     *
     * @return integer
     */
    public function getPointBadge()
    {
        return $this->pointBadge;
    }

    /**
     * Set nbMasterBadge
     * @param integer $nbMasterBadge
     * @return Team
     */
    public function setNbMasterBadge(int $nbMasterBadge)
    {
        $this->nbMasterBadge = $nbMasterBadge;

        return $this;
    }

    /**
     * Get nbMasterBadge
     *
     * @return integer
     */
    public function getNbMasterBadge()
    {
        return $this->nbMasterBadge;
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
