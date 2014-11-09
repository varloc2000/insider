<?php

namespace Insider\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Insider\AppBundle\Entity\GameRepository")
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
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="guestGames")
     */
    private $guest;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="homeGames")
     */
    private $home;

    /**
     * @var integer
     *
     * @ORM\Column(name="guest_goal", type="integer")
     */
    private $guestGoal;

    /**
     * @var integer
     *
     * @ORM\Column(name="home_goal", type="integer")
     */
    private $homeGoal;

    /**
     * @var integer
     *
     * @ORM\Column(name="tour", type="integer")
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="games")
     */
    private $league;

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
     * Set guest
     *
     * @param guid $guest
     * @return Game
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return guid 
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set home
     *
     * @param \stdClass $home
     * @return Game
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return \stdClass 
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set guestGoal
     *
     * @param integer $guestGoal
     * @return Game
     */
    public function setGuestGoal($guestGoal)
    {
        $this->guestGoal = $guestGoal;

        return $this;
    }

    /**
     * Get guestGoal
     *
     * @return integer 
     */
    public function getGuestGoal()
    {
        return $this->guestGoal;
    }

    /**
     * Set homeGoal
     *
     * @param integer $homeGoal
     * @return Game
     */
    public function setHomeGoal($homeGoal)
    {
        $this->homeGoal = $homeGoal;

        return $this;
    }

    /**
     * Get homeGoal
     *
     * @return integer 
     */
    public function getHomeGoal()
    {
        return $this->homeGoal;
    }

    /**
     * Get tour.
     *
     * @return integer
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * Set tour.
     *
     * @param integer $tour
     * @return self
     */
    public function setTour($tour)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get league.
     *
     * @return League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * Set league.
     *
     * @param League $league
     * @return self
     */
    public function setLeague($league)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHomeWin()
    {
        return ($this->homeGoal > $this->guestGoal);
    }

    /**
     * @return boolean
     */
    public function isGuestWin()
    {
        return ($this->homeGoal < $this->guestGoal);
    }

    /**
     * @return boolean
     */
    public function isDraw()
    {
        return ($this->homeGoal == $this->guestGoal);
    }

    /**
     * @return Team|null
     */
    public function getWinner()
    {
        if ($this->homeGoal > $this->guestGoal) {
            return $this->home;
        } elseif ($this->homeGoal < $this->guestGoal) {
            return $this->guest;
        }

        return null;
    }

    /**
     * @return Team|null
     */
    public function getLooser()
    {
        if ($this->homeGoal > $this->guestGoal) {
            return $this->guest;
        } elseif ($this->homeGoal < $this->guestGoal) {
            return $this->home;
        }

        return null;
    }
}
