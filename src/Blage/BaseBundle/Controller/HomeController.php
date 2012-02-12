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
        return array();
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
