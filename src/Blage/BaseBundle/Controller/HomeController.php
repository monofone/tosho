<?php

namespace Blage\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Template()
     */
    public function userAction()
    {
        $authOk = $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');
        if($authOk){
            $user = $this->get('security.context')->getToken()->getUser();
            return array('authOk' => $authOk, 'user' => $user);
        }
        
        return array('authOk' => false);
    }
    
    /**
     * @Route("about/tosho", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
}
