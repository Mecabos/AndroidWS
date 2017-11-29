<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 7:27 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Achievement
 * @ORM\Entity(repositoryClass="WSBundle\Repository\AchievementRepository")
 * @ORM\Table(name="Achievement")
 */
class Achievement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\Project")
     * @ORM\Column(name="name", type="string",length = 255,nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(name="description", type="string", length = 255,nullable=false)
     */
    private $description;

    /**
     * CollaborationGroup constructor.
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}