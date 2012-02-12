<?php

namespace Blage\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Blage\TaskBundle\Entity\ToshiInvitation;
use Blage\TaskBundle\Form\ToshiInvitationType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Blage\TaskBundle\Entity\User;
/**
 * Description of ToshiController
 *
 * @author srohweder
 */
class ToshiController extends Controller
{
    /**
     * @Route("/{username}/toshies", name="toshi_list")
     * @Template()
     */
    public function listAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $toshies = $this->getDoctrine()->getRepository('BlageTaskBundle:ToshiList')->findBy(array('user' => $user->getId()));
        $invitations = $this->getDoctrine()->getRepository('BlageTaskBundle:ToshiInvitation')->getPendingInvitations($user);

        return array('invitations' => $invitations, 'toshies' => $toshies);
    }
    
    /**
     * @Route("/toshies/invite", name="toshi_invite")
     * @Template()
     */
    public function inviteAction(Request $request)
    {
        $form = $this->createForm(new ToshiInvitationType());
        if($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            if($form->isValid()){
                
                $invitation = new ToshiInvitation();
                $user = $this->get('security.context')->getToken()->getUser();
                $invitation->setUser($user);
                $formData = $form->getData();
                $invitation->setInvitationEmail($formData['email']);
                
                $this->sendInvitationMail($invitation, $user, $formData);
                
                $this->getDoctrine()->getEntityManager()->persist($invitation);
                $this->getDoctrine()->getEntityManager()->flush();
                
                $url = $this->generateUrl('toshi_invitation_send');
                
                return new RedirectResponse($url);
            }
        }
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/invitation/send", name="toshi_invitation_send")
     * @Template()
     */
    public function invitationSendAction()
    {
        return array();
    }
    
    /**
     * @Route("/toshi/add/to/list/{toshiid}", name="add_toshi_to_list")
     */
    public function addToshiToToshiListAction($toshiid)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $toshi = $this->getDoctrine()->getRepository('BlageTaskBundle:User')->findOneById($toshiid);
        $listEntry = new \Blage\TaskBundle\Entity\ToshiList();
        $listEntry->setUser($user);
        $listEntry->setToshi($toshi);
        $this->getDoctrine()->getEntityManager()->persist($listEntry);
        $this->getDoctrine()->getEntityManager()->flush();
        
        return new Response(json_encode(array('username' => $toshi->getUsername(), 'id' => $toshi->getId())), 200, array('Content-type'=>'application/json'));
    }
    
    protected function sendInvitationMail(ToshiInvitation $invitation, User $sender, array $formData)
    {
        $viewdata['email'] = $formData['email'];
        $viewdata['token'] = $invitation->getInvitationToken();
        $viewdata['username'] = $sender->getUsername();
        
        $messageTxt = $this->renderView('BlageTaskBundle:Toshi:invitationEmail.txt.twig', $viewdata);
        
        $message = \Swift_Message::newInstance()
                ->setFrom($sender->getEmail())
                ->setBody($messageTxt)
                ->setTo($viewdata['email'])
                ->setSubject('Tosho: invitation from a friend');
        
        $this->get('mailer')->send($message);
    }
    
}
