<?php

namespace Murf\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MurfSet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Murf\MatchBundle\Entity\MurfSetRepository")
 */
class MurfSet
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
     * @ORM\OneToMany(targetEntity="Game", mappedBy="murfSet")
     **/
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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
     * Get games
     *
     * @return Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * add game
     *
     * @param Game $game
     * @return MurfSet
     */
    public function addGame(Game $game)
    {
        $this->games->add($game);

        return $this;
    }

    /**
     * Set games
     *
     * @param Collection $games
     * @return MurfSet
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }
}
