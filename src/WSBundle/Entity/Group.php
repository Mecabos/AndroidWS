<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/29/2017
 * Time: 6:17 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 * @ORM\Entity(repositoryClass="WSBundle\Repository\GroupRepository")
 * @ORM\Table(name="group")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\Project")
     * @ORM\JoinColumn(name="project", referencedColumnName="id",nullable=true)
     */
    private $project;
    /**
     * @ORM\Column(type="string", length = 255,nullable=false)
     */
    private $name;
    /**
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * Group constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }




}