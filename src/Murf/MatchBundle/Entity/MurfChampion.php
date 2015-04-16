<?php

namespace Murf\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MurfChampion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MurfChampion
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
     * @var integer
     *
     * @ORM\Column(name="championId", type="integer")
     */
    private $championId;

    /**
     * @var string
     *
     * @ORM\Column(name="championKey", type="string", length=255)
     */
    private $championKey;

    /**
     * @var string
     *
     * @ORM\Column(name="championName", type="string", length=255)
     */
    private $championName;

    /**
     * @var string
     *
     * @ORM\Column(name="championTitle", type="string", length=255)
     */
    private $championTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;


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
     * Set championId
     *
     * @param integer $championId
     * @return MurfChampion
     */
    public function setChampionId($championId)
    {
        $this->championId = $championId;

        return $this;
    }

    /**
     * Get championId
     *
     * @return integer
     */
    public function getChampionId()
    {
        return $this->championId;
    }

    /**
     * Set championKey
     *
     * @param string $championKey
     * @return MurfChampion
     */
    public function setChampionKey($championKey)
    {
        $this->championKey = $championKey;

        return $this;
    }

    /**
     * Get championKey
     *
     * @return string
     */
    public function getChampionKey()
    {
        return $this->championKey;
    }

    /**
     * Set championName
     *
     * @param string $championName
     * @return MurfChampion
     */
    public function setChampionName($championName)
    {
        $this->championName = $championName;

        return $this;
    }

    /**
     * Get championName
     *
     * @return string
     */
    public function getChampionName()
    {
        return $this->championName;
    }

    /**
     * Set championTitle
     *
     * @param string $championTitle
     * @return MurfChampion
     */
    public function setChampionTitle($championTitle)
    {
        $this->championTitle = $championTitle;

        return $this;
    }

    /**
     * Get championTitle
     *
     * @return string
     */
    public function getChampionTitle()
    {
        return $this->championTitle;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return MurfChampion
     */
    public function setRegion($region)
    {
        $this->region = $region;

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
}