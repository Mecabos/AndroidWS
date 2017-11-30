<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/30/2017
 * Time: 4:01 AM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="rate")
 *
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $user;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\Project")
     * @ORM\JoinColumn(name="project", referencedColumnName="id",nullable=true,onDelete="CASCADE")
     */
    private $project;
    /**
     *
     * @ORM\Column(name="rateDate", type="datetime")
     */
    private $rateDate;
    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", nullable=false)
     */
    private $value;

    /**
     * Rate constructor.
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
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getRateDate()
    {
        return $this->rateDate;
    }

    /**
     * @param mixed $rateDate
     */
    public function setRateDate($rateDate)
    {
        $this->rateDate = $rateDate;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}