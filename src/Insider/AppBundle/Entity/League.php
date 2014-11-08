<?php

namespace Insider\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * League
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Insider\AppBundle\Entity\LeagueRepository")
 */
class League
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Game", mappedBy="league", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $games;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="tour_count", type="string", length=255)
     */
    private $tourCount = 0;


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
     * Set games
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $games
     * @return League
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * Add game
     *
     * @param Game $game
     * @return League
     */
    public function addGame(Game $game)
    {
        $game->setLeague($this);
        $this->games->add($game);

        return $this;
    }

    /**
     * Get games
     *
     * @return array 
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return League
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tourCount
     *
     * @param string $tourCount
     * @return League
     */
    public function setTourCount($tourCount)
    {
        $this->tourCount = $tourCount;

        return $this;
    }

    /**
     * Get tourCount
     *
     * @return string 
     */
    public function getTourCount()
    {
        return $this->tourCount;
    }
}
