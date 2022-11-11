<?php

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="dwh_game")
 * @ORM\Entity(repositoryClass="VideoGamesRecords\DwhBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="nbPost", type="integer", nullable=false, options={"default":0})
     */
    private $nbPost = 0;

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
     * @return Game
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
     * @return Game
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
     * Set nbPost
     * @param integer $nbPost
     * @return Game
     */
    public function setNbPost(int $nbPost)
    {
        $this->nbPost = $nbPost;

        return $this;
    }

    /**
     * Get nbPost
     *
     * @return integer
     */
    public function getNbPost()
    {
        return $this->nbPost;
    }

    /**
     * Set nbPostDay
     * @param integer $nbPostDay
     * @return Game
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
