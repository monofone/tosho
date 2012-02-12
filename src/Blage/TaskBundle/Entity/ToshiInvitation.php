<?php

namespace Blage\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This describes the a invitation from one user 
 * and is filled with the related toshi when he/she registers
 * 
 * @ORM\Entity(repositoryClass="Blage\TaskBundle\Repository\ToshiInvitationsRepository")
 * @ORM\Table(name="toshi_invitations")
 */
class ToshiInvitation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $invitationToken;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $toshi;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $invitationEmail;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $invitationDate;
    
    function __construct()
    {
        $this->invitationToken = uniqid();
        $this->invitationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set invitationToken
     *
     * @param string $invitationToken
     */
    public function setInvitationToken($invitationToken)
    {
        $this->invitationToken = $invitationToken;
    }

    /**
     * Get invitationToken
     *
     * @return string 
     */
    public function getInvitationToken()
    {
        return $this->invitationToken;
    }

    /**
     * Set user
     *
     * @param Blage\TaskBundle\Entity\User $user
     */
    public function setUser(\Blage\TaskBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Blage\TaskBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set toshi
     *
     * @param Blage\TaskBundle\Entity\User $toshi
     */
    public function setToshi(\Blage\TaskBundle\Entity\User $toshi)
    {
        $this->toshi = $toshi;
    }

    /**
     * Get toshi
     *
     * @return Blage\TaskBundle\Entity\User 
     */
    public function getToshi()
    {
        return $this->toshi;
    }
    
    

    /**
     * Set invitationEmail
     *
     * @param string $invitationEmail
     */
    public function setInvitationEmail($invitationEmail)
    {
        $this->invitationEmail = $invitationEmail;
    }

    /**
     * Get invitationEmail
     *
     * @return string 
     */
    public function getInvitationEmail()
    {
        return $this->invitationEmail;
    }

    /**
     * Set invitationDate
     *
     * @param datetime $invitationDate
     */
    public function setInvitationDate($invitationDate)
    {
        $this->invitationDate = $invitationDate;
    }

    /**
     * Get invitationDate
     *
     * @return datetime 
     */
    public function getInvitationDate()
    {
        return $this->invitationDate;
    }
}