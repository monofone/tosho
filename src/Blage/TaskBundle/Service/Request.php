<?php

namespace Blage\TaskBundle\Service;

use Blage\TaskBundle\Entity\User;
/**
 * Description of TaskData
 *
 * @author srohweder
 */
class Request
{
    protected $taskData;
    
    protected $user;
        
    public function getTaskData()
    {
        return $this->taskData;
    }

    public function setTaskData($taskData)
    {
        $this->taskData = $taskData;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }


}
