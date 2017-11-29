<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/29/2017
 * Time: 6:43 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="WSBundle\Repository\MembershipRepository")
 * @ORM\Table(name="membership")
 *
 */
class Membership
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="CollaborationGroup")
     * @ORM\JoinColumn(name="CollaborationGroup", referencedColumnName="id",nullable=true,onDelete="CASCADE")
     */
    private $CollaborationGroup;
    /**
     * @ORM\Column(name="isAdmin",type="boolean",nullable=false)
     */
    private $isAdmin;
    /**
     *
     * @ORM\Column(name="adherationDate", type="datetime")
     */
    private $adherationDate;

    /**
     * Membership constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getAdherationDate()
    {
        return $this->adherationDate;
    }

    /**
     * @param mixed $adherationDate
     */
    public function setAdherationDate($adherationDate)
    {
        $this->adherationDate = $adherationDate;
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
    public function getCollaborationGroup()
    {
        return $this->CollaborationGroup;
    }

    /**
     * @param mixed $CollaborationGroup
     */
    public function setCollaborationGroup($CollaborationGroup)
    {
        $this->CollaborationGroup = $CollaborationGroup;
    }

    /**
     * @return mixed
     */
    public function getisAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }


}