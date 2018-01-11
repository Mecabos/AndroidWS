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
 * CollaborationGroup
 * @ORM\Entity(repositoryClass="WSBundle\Repository\CollaborationGroupRepository")
 * @ORM\Table(name="collaborationgroup")
 */
class CollaborationGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length = 255,nullable=false, unique=true)
     */
    private $name;
    /**
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="creator", referencedColumnName="id",nullable=false)
     */
    private $creator;

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
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }


}