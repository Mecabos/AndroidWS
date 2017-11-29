<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/13/2017
 * Time: 8:09 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 * @ORM\Entity(repositoryClass="WSBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */

class Project
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     *
     * @ORM\Column(name="finishDate", type="datetime")
     */
    private $finishDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=100)
     */
    private $shortDescription;

    /**
     * @var float
     *
     * @ORM\Column(name="budget", type="float")
     */
    private $budget;

    /**
     * @var float
     *
     * @ORM\Column(name="currentBudget", type="float")
     */
    private $currentBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="equipmentsList", type="string", length=400)
     */
    private $equipmentsList;

    /**
     * @var string
     *
     * @ORM\Column(name="servicesList", type="string", length=400)
     */
    private $servicesList;
    /**
     * @ORM\Column(type="integer",options={"default":0},nullable=false)
     */
    private $isCanceled;

    /**
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\CollaborationGroup")
     * @ORM\JoinColumn(name="collaborationGroup", referencedColumnName="id",nullable=true)
     */
    private $collaborationGroup;


    /**
     * Project constructor.
     * @param int $id
     * @param string $name
     * @param $creationDate
     * @param $startDate
     * @param $finishDate
     * @param string $description
     * @param float $budget
     * @param float $currentBudget
     * @param string $equipmentsList
     * @param string $servicesList
     */
    public function __construct($id, $name, $creationDate, $startDate, $finishDate, $description, $budget, $currentBudget, $equipmentsList, $servicesList)
    {
        $this->id = $id;
        $this->name = $name;
        $this->creationDate = $creationDate;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
        $this->description = $description;
        $this->budget = $budget;
        $this->currentBudget = $currentBudget;
        $this->equipmentsList = $equipmentsList;
        $this->servicesList = $servicesList;
    }

    /**
     * @return mixed
     */
    public function getisCanceled()
    {
        return $this->isCanceled;
    }

    /**
     * @param mixed $isCanceled
     */
    public function setIsCanceled($isCanceled)
    {
        $this->isCanceled = $isCanceled;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
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

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * @param mixed $finishDate
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }



    /**
     * @return float
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param float $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return float
     */
    public function getCurrentBudget()
    {
        return $this->currentBudget;
    }

    /**
     * @param float $currentBudget
     */
    public function setCurrentBudget($currentBudget)
    {
        $this->currentBudget = $currentBudget;
    }

    /**
     * @return string
     */
    public function getEquipmentsList()
    {
        return $this->equipmentsList;
    }

    /**
     * @param string $equipmentsList
     */
    public function setEquipmentsList($equipmentsList)
    {
        $this->equipmentsList = $equipmentsList;
    }

    /**
     * @return string
     */
    public function getServicesList()
    {
        return $this->servicesList;
    }

    /**
     * @param string $servicesList
     */
    public function setServicesList($servicesList)
    {
        $this->servicesList = $servicesList;
    }

    /**
     * @return mixed
     */
    public function getCollaborationGroup()
    {
        return $this->collaborationGroup;
    }

    /**
     * @param mixed $collaborationGroup
     */
    public function setCollaborationGroup($collaborationGroup)
    {
        $this->collaborationGroup = $collaborationGroup;
    }





}