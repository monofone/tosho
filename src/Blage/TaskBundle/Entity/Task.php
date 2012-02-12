<?php

namespace Blage\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Describes a todo
 * 
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDone;
    
    /**
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\ManyToOne(targetEntity="TaskList")
     */
    protected $tasklist;
    
    public function __construct()
    {
         $this->created = new \DateTime();
         $this->isDone = false;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
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
     * Set tasklist
     *
     * @param Blage\TaskBundle\Entity\TaskList $tasklist
     */
    public function setTasklist(\Blage\TaskBundle\Entity\TaskList $tasklist)
    {
        $this->tasklist = $tasklist;
    }

    /**
     * Get tasklist
     *
     * @return Blage\TaskBundle\Entity\TaskList 
     */
    public function getTasklist()
    {
        return $this->tasklist;
    }
    
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'user_id' => $this->getUser()->getId(),
            'isDone' => $this->getIsDone(),
            'tasklist_id' => $this->getTasklist()->getId()
            );
    }
}