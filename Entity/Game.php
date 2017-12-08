<?php

namespace VideoGamesRecords\DwhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Game
 *
 * @ORM\Table(name="dwh_game", indexes={@ORM\Index(name="idxGame", columns={"idGame"}), @ORM\Index(name="idxDate", columns={"date"})})
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
     * @var date
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
     *
     * @param integer $id
     * @return Game
     */
    public function setId($id)
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
     *
     * @param string $date
     * @return Game
     */
    public function setDate($date)
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
     *
     * @param integer $nbPost
     * @return Game
     */
    public function setNbPost($nbPost)
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
     *
     * @param integer $nbPostDay
     * @return Game
     */
    public function setNbPostDay($nbPostDay)
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
     * @param $row
     */
    public function setFromArray($row)
    {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
}
