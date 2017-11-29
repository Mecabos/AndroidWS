<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/29/2017
 * Time: 8:10 PM
 */

namespace WSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="WSBundle\Repository\CommentRepository")
 * @ORM\Table(name="follow")
 *
 */

class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @ORM\JoinColumn(name="group", referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $project;
    /**
     *
     * @ORM\Column(name="commentDate", type="datetime")
     */
    private $commentDate;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=550)
     */
    private $text;

}