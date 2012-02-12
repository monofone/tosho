<?php

namespace Blage\TaskBundle\Service;

use Doctrine\ORM\EntityManager;
use Blage\TaskBundle\Entity\Task;
use Blage\TaskBundle\Entity\TaskMapper;
use Lopi\Bundle\PusherBundle\Pusher\Pusher;
/**
 * Service to handle all Task dependent stuff
 *
 * @author srohweder
 */
class TaskService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $pusher;
    protected $memcache;
    
    public function __construct(EntityManager $em, Pusher $pusher, \Memcached $memcache)
    {
        $this->em = $em;
        $this->pusher = $pusher;
        $this->memcache = $memcache;
    }
    
    public function storeTask(Request $taskData)
    {
        $savedTasks = 0;
        $updatedTasks = 0;
        $task = $taskData->getTaskData();
        $user = $taskData->getUser();
        $newTaskObj = null;
        if(isset($task->id)){
            $taskObj = $this->getRepository()->find($task->id);
            if(isset($task->_destroy) && $task->_destroy){
                $this->em->remove($taskObj);
            }else{
                $taskObj = TaskMapper::mergeTaskData($taskObj, $task, $user);
            }
        }else{
            $task->tasklist = $this->getTaskListRepository()->findOneById($task->tasklist_id);
            $newTaskObj = TaskMapper::taskFromStdClass($task, $user);
            $this->getEntityManager()->persist($newTaskObj);
        }
        
        $this->getEntityManager()->flush();
        
        if($newTaskObj){
            $trigger = $this->memcache->get($user->getUsername()."-".$newTaskObj->getTasklist()->getId());
            if($trigger){
                $this->pusher->trigger($user->getUsername()."-".$newTaskObj->getTasklist()->getListTitle(), 'new-item', $newTaskObj->toArray());
            }
        }
        
        return $newTaskObj;
    }
    
    public function getUsersTaskList(Request $request)
    {
        return $this->getRepository()->findByUser($request->getUser()->getId());
    }
    
    protected function getRepository()
    {
        return $this->em->getRepository('BlageTaskBundle:Task');
    }
    
    protected function getTaskListRepository()
    {
        return $this->em->getRepository('BlageTaskBundle:TaskList');
    }
    
    protected function getUsersTaskListById($tasklistId, $user)
    {
        return $this->getTaskListRepository()->findOneBy(array('id' => $tasklistId, 'user' => $user->getId()));
    }
    
    protected function getEntityManager()
    {
        return $this->em;
    }
}
