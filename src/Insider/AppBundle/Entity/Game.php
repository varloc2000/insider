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
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $blue;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $red;

    /**
     * @var integer
     *
     * @ORM\Column(name="blue_goal", type="integer")
     */
    private $blueGoal;

    /**
     * @var integer
     *
     * @ORM\Column(name="red_goal", type="integer")
     */
    private $redGoal;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="games")
     */
    private $season;


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
     * Set blue
     *
     * @param guid $blue
     * @return Game
     */
    public function setBlue($blue)
    {
        $this->blue = $blue;

        return $this;
    }

    /**
     * Get blue
     *
     * @return guid 
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Set red
     *
     * @param \stdClass $red
     * @return Game
     */
    public function setRed($red)
    {
        $this->red = $red;

        return $this;
    }

    /**
     * Get red
     *
     * @return \stdClass 
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Set blueGoal
     *
     * @param integer $blueGoal
     * @return Game
     */
    public function setBlueGoal($blueGoal)
    {
        $this->blueGoal = $blueGoal;

        return $this;
    }

    /**
     * Get blueGoal
     *
     * @return integer 
     */
    public function getBlueGoal()
    {
        return $this->blueGoal;
    }

    /**
     * Set redGoal
     *
     * @param integer $redGoal
     * @return Game
     */
    public function setRedGoal($redGoal)
    {
        $this->redGoal = $redGoal;

        return $this;
    }

    /**
     * Get redGoal
     *
     * @return integer 
     */
    public function getRedGoal()
    {
        return $this->redGoal;
    }

    /**
     * Get season.
     *
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set season.
     *
     * @param Season $season
     *
     * @return self
     */
    private function _setSeason($season)
    {
        $this->season = $season;

        return $this;
    }
}
