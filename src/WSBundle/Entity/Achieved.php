<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 8:16 PM
 */

namespace WSBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="WSBundle\Repository\AchievedRepository")
 * @ORM\Table(name="Achieved")
 *
 */
class Achieved
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $user;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\Achievement")
     * @ORM\JoinColumn(name="achievement", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $achievement;
    /**
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $achievementDate;

    /**
     * Achieved constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getAchievement()
    {
        return $this->achievement;
    }

    /**
     * @param mixed $achievement
     */
    public function setAchievement($achievement)
    {
        $this->achievement = $achievement;
    }

    /**
     * @return mixed
     */
    public function getAchievementDate()
    {
        return $this->achievementDate;
    }

    /**
     * @param mixed $achievementDate
     */
    public function setAchievementDate($achievementDate)
    {
        $this->achievementDate = $achievementDate;
    }


}