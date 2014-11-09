<?php

namespace Insider\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="Insider\AppBundle\Entity\TeamRepository")
 */
class Team
{
    /**
     * Played
     * The number of matches played this season.
     * @var integer
     */
    private $P = 0;

    /**
     * Won
     * The number of matches won this season.
     * @var integer
     */
    private $W = 0;

    /**
     * Drawn
     * The number of matches drawn this season.
     * @var integer
     */
    private $D = 0;

    /**
     * Lost
     * The number of matches lost this season.
     * @var integer
     */
    private $L = 0;

    /**
     * Goals for
     * The number of goals scored this season.
     * @var integer
     */
    private $GF = 0;

    /**
     * Goals against
     * The number of goals conceded this season
     * @var integer
     */
    private $GA = 0;

    /**
     * Goal difference
     * The number of goals for (GF) minus the number of goals against (GA).
     * @var integer
     */
    private $GD = 0;

    /**
     * Points
     * The number of points scored this season.
     *     Win = 3
     *     Draw = 1
     *     Loss = 0
     * @var integer
     */
    private $PTS = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="home")
     */
    private $homeGames;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="guest")
     */
    private $guestGames;


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
     * Set name
     *
     * @param string $name
     * @return Team
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
     * Get homeGames.
     *
     * @return mixed
     */
    public function getHomeGames()
    {
        return $this->homeGames;
    }

    /**
     * Get guestGames.
     *
     * @return mixed
     */
    public function getGuestGames()
    {
        return $this->guestGames;
    }

    /**
     * @return integer
     */
    public function getPlayed()
    {
        return $this->P;
    }

    /**
     * @param integer $P the 
     * @return self
     */
    public function setPlayed($P)
    {
        $this->P = $P;

        return $this;
    }

    /**
     * @return integer
     */
    public function getWon()
    {
        return $this->W;
    }

    /**
     * @param integer $W the 
     * @return self
     */
    public function setWon($W)
    {
        $this->W = $W;

        return $this;
    }

    /**
     * @return integer
     */
    public function getDrawn()
    {
        return $this->D;
    }

    /**
     * @param integer $D the 
     * @return self
     */
    public function setDrawn($D)
    {
        $this->D = $D;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLost()
    {
        return $this->L;
    }

    /**
     * @param integer $L the 
     * @return self
     */
    public function setLost($L)
    {
        $this->L = $L;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGF()
    {
        return $this->GF;
    }

    /**
     * @param integer $GF the 
     * @return self
     */
    public function setGF($GF)
    {
        $this->GF = $GF;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGA()
    {
        return $this->GA;
    }

    /**
     * @param integer $GA the 
     * @return self
     */
    public function setGA($GA)
    {
        $this->GA = $GA;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGD()
    {
        return $this->GD;
    }

    /**
     * @param integer $GD the 
     * @return self
     */
    public function setGD($GD)
    {
        $this->GD = $GD;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPTS()
    {
        return $this->PTS;
    }

    /**
     * @param integer $PTS the 
     * @return self
     */
    public function setPTS($PTS)
    {
        $this->PTS = $PTS;

        return $this;
    }

    public function calculateGamesStatistic()
    {
        foreach($this->getHomeGames() as $game) {
            $this->P++;
            if ($game->isHomeWin()) {
                $this->W++;
            } elseif ($game->isGuestWin()) {
                $this->L++;
            } elseif ($game->isDraw()) {
                $this->D++;
            }
        }

        foreach($this->getGuestGames() as $game) {
            $this->P++;
            if ($game->isGuestWin()) {
                $this->W++;
            } elseif ($game->isHomeWin()) {
                $this->L++;
            } elseif ($game->isDraw()) {
                $this->D++;
            }
        }
    }
}
