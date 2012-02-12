<?php

namespace Blage\TaskBundle\Entity;

/**
 * Description of TaskMapper
 *
 * @author srohweder
 */
class TaskMapper
{
    public static function taskFromStdClass(\stdClass $taskData, User $user)
    {
        $task = new Task();
        $task->setTitle($taskData->title);
        $task->setUser($user);
        $task->setTasklist($taskData->tasklist);
        if(isset($taskData->isDone)){
            $task->setIsDone($taskData->isDone);
        }
        return $task;
    }
    
    public static function mergeTaskData(Task $task, \stdClass $taskData, User $user)
    {
        $task->setIsDone($taskData->isDone);
        $task->setUser($user);
        
        return $task;
    }
}
