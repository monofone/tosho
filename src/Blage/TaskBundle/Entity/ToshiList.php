<?php

namespace Blage\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This describes a list of friends from one user
 * 
 * @ORM\Entity(repositoryClass="Blage\TaskBundle\Repository\ToshiListRepository")
 * @ORM\Table(name="toshi_list",uniqueConstraints={@ORM\UniqueConstraint(name="uniqe_friend_idx",columns={"toshies_id","user_id"})})
 */
class ToshiList
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * 
     */
    protected $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $toshies;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getToshi()
    {
        return $this->toshies;
    }

    public function setToshi(User $toshie)
    {
        $this->toshies = $toshie;
    }


    /**
     * Set toshies
     *
     * @param Blage\TaskBundle\Entity\User $toshies
     */
    public function setToshies(\Blage\TaskBundle\Entity\User $toshies)
    {
        $this->toshies = $toshies;
    }

    /**
     * Get toshies
     *
     * @return Blage\TaskBundle\Entity\User 
     */
    public function getToshies()
    {
        return $this->toshies;
    }
}