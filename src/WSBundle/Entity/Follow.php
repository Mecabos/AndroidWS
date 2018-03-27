<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/29/2017
 * Time: 7:30 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="WSBundle\Repository\FollowRepository")
 * @ORM\Table(name="follow")
 *
 */
class Follow
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
     * @ORM\Column(name="followDate", type="datetime")
     */
    private $followDate;

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
    public function getFollowDate()
    {
        return $this->followDate;
    }

    /**
     * @param mixed $followDate
     */
    public function setFollowDate($followDate)
    {
        $this->followDate = $followDate;
    }



}