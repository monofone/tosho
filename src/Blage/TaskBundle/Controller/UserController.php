<?php

namespace Blage\TaskBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Controller for registration with a friends token
 */
class UserController extends BaseController
{

    /**
     * @Route("/register/{invitationtoken}", name="register_with_token")
     */
    public function registerWithTokenAction($invitationtoken)
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();
            
            $invitation = $this->container->get('doctrine.orm.entity_manager')
                    ->getRepository('BlageTaskBundle:ToshiInvitation')
                    ->findOneBy(array('invitationToken' => $invitationtoken));
            $invitation->setToshi($user);
            $this->container->get('doctrine.orm.entity_manager')->flush();

            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $this->authenticateUser($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('BlageTaskBundle:User:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
                    'invitationtoken' => $invitationtoken,
                    'theme' => $this->container->getParameter('fos_user.template.theme'),
                ));
    }

}
