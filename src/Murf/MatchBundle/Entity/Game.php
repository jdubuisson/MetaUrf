<?php

namespace Murf\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="MurfGame")
 * @ORM\Entity
 */
class Game
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="winners", type="array")
     */
    private $winners;

    /**
     * @var array
     *
     * @ORM\Column(name="losers", type="array")
     */
    private $losers;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="region", type="string")
     */
    private $region;

    /**
     * @var \DateTime
     *
     *
     * @ORM\Column(name="matchCreation", type="datetime")
     */
    private $matchCreation;
    /**
     * @var integer
     *
     * @ORM\Column(name="matchId", type="integer")
     */
    private $matchId;

    /**
     * @var MurfSet
     * @ORM\ManyToOne(targetEntity="MurfSet", inversedBy="games")
     * @ORM\JoinColumn(name="set_id", referencedColumnName="id")
     */
    private $murfSet;

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
     * Get winners
     *
     * @return array
     */
    public function getWinners()
    {
        return $this->winners;
    }

    /**
     * add winner
     *
     * @param int $int
     * @return Game
     */
    public function addWinner($int)
    {
        $this->winners[] = $int;

        return $this;
    }

    /**
     * Set winners
     *
     * @param array $array
     * @return Game
     */
    public function setWinners($array)
    {
        $this->winners = $array;

        return $this;
    }

    /**
     * Get losers
     *
     * @return array
     */
    public function getLosers()
    {
        return $this->losers;
    }

    /**
     * add loser
     *
     * @param int $int
     * @return Game
     */
    public function addLoser($int)
    {
        $this->losers[] = $int;

        return $this;
    }

    /**
     * Set losers
     *
     * @param array $array
     * @return Game
     */
    public function setLosers($array)
    {
        $this->losers = $array;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Game
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get matchCreation
     *
     * @return \DateTime
     */
    public function getMatchCreation()
    {
        return $this->matchCreation;
    }

    /**
     * Set matchCreation
     *
     * @param \DateTime $matchCreation
     * @return Game
     */
    public function setMatchCreation($matchCreation)
    {
        $this->matchCreation = $matchCreation;

        return $this;
    }

    /**
     * Get matchId
     *
     * @return integer
     */
    public function getMatchId()
    {
        return $this->matchId;
    }

    /**
     * Set matchId
     *
     * @param integer $matchId
     * @return Game
     */
    public function setMatchId($matchId)
    {
        $this->matchId = $matchId;

        return $this;
    }

    /**
     * Get murfSet
     *
     * @return MurfSet
     */
    public function getMurfSet()
    {
        return $this->murfSet;
    }

    /**
     * Set murfSet
     *
     * @param MurfSet $set
     * @return Game
     */
    public function setMurfSet(MurfSet $set)
    {
        $this->murfSet = $set;

        return $this;
    }
}
