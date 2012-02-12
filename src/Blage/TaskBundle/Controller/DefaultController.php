<?php

namespace Blage\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Blage\TaskBundle\Entity\Task;
use Blage\TaskBundle\Entity\TaskMapper;
use Blage\TaskBundle\Service\Request as TaskRequest;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    protected function getTasklistRepository()
    {
        return $this->getDoctrine()->getRepository('BlageTaskBundle:TaskList');
    }
    /**
     * @Route("/{username}/tasklists", name="tasklists")
     * @Template()
     */
    public function indexAction($username)
    {
        $tasklists = $this->getTasklistRepository()->findByUsername($username);
        
        return array('tasklists' => $tasklists);
    }
    
    
    /**
     * @Route("/{username}/tasklist/{tasklistTitle}/edit",name="tasklist_edit")
     * @Template("BlageTaskBundle:Default:tasklist.html.twig")
     */
    public function tasklistEditAction($username, $tasklistTitle)
    {
        $tasklist = $this->getTasklistRepository()->findOneByUsernameAndTitle($username, $tasklistTitle);
        
        return array('tasklist' => $tasklist, 'isEdit' => true);
    }
        /**
     * @Route("/{username}/tasklist/{tasklistTitle}/view",name="tasklist_view")
     * @Template("BlageTaskBundle:Default:tasklist.html.twig")
     */
    public function tasklistViewAction($username, $tasklistTitle)
    {
        $tasklist = $this->getTasklistRepository()->findOneByUsernameAndTitle($username, $tasklistTitle);
        
        return array('tasklist' => $tasklist, 'isEdit' => false);
    }
    /**
     * @Route("/tasksSave")
     */
    public function saveTasksAction()
    {
        $savedTasks = 0;
        $updatedTasks = 0;
        $request = $this->getRequest();
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $taskService = $this->get('blage_task.taskservice');
        /* @var $taskService \Blage\TaskBundle\Service\TaskService */
        
        if(!$taskData = json_decode($request->get('data'))){
            return new Response(json_encode(array('error' => true, 'error_msg' => 'tasks could not be saved')), 200, array('Content-Type' => 'application/json'));
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $request = new TaskRequest();
        $request->setTaskData($taskData);
        $request->setUser($user);
        
        $newTaskObj = $taskService->storeTask($request);
        
        if($newTaskObj){
            return new Response(json_encode(array('newTask' => true, 'title' => $newTaskObj->getTitle(), 'id' => $newTaskObj->getId())), 200, array('Content-Type' => 'application/json'));
        }else{
            return new Response(json_encode(array('something done')), 200, array('Content-Type' => 'application/json'));
        }
    }
    
}
