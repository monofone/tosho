<?php

namespace Blage\TaskBundle\Form;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Mailer\MailerInterface;

/**
 * extra registration handler to create the initial list on registration
 */
class RegistrationFormHandler extends BaseHandler
{
    
    protected $em;
    
    public function __construct(Form $form, Request $request, UserManagerInterface $userManager, MailerInterface $mailer, EntityManager $em)
    {
        parent::__construct($form, $request, $userManager, $mailer);
        $this->em = $em;
    }
    
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        parent::onSuccess($user, $confirmation);
        
        $list = new \Blage\TaskBundle\Entity\TaskList();
        $list->setUser($user);
        $list->setListTitle('shopping');
        $this->em->persist($list);
        $this->em->flush();
        
    }
}