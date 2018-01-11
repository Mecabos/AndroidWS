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
 * @ORM\Table(name="payment")
 *
 */
class Payment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="WSBundle\Entity\Project")
     * @ORM\JoinColumn(name="project", referencedColumnName="id",nullable=true,onDelete="CASCADE")
     */
    private $project;
    /**
     *
     * @ORM\Column(name="paymentDate", type="datetime")
     */
    private $paymentDate;
    /**
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

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
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param mixed $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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







}