<?php

namespace Blage\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Describes a todolist
 * 
 * @ORM\Entity(repositoryClass="Blage\TaskBundle\Repository\TaskListRepository")
 * @ORM\Table(name="task_lists", uniqueConstraints={@ORM\UniqueConstraint(name="title_idx",columns={"listTitle","user_id"})})
 */
class TaskList
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
    protected $listTitle;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;
    
    /**
     * @ORM\OneToMany(targetEntity="Task",mappedBy="tasklist")
     */
    protected $tasks;

    function __construct()
    {
        $this->tasks = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getListTitle()
    {
        return $this->listTitle;
    }

    public function setListTitle($listTitle)
    {
        $this->listTitle = $listTitle;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }



    /**
     * Add tasks
     *
     * @param Blage\TaskBundle\Entity\Task $tasks
     */
    public function addTask(\Blage\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    }
}