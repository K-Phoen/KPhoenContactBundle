<?php

namespace KPhoen\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\EventDispatcher\Event\ContactEvent;
use KPhoen\ContactBundle\Model\Message;


class ContactController extends Controller
{
    /**
     * @Template()
     */
    public function contactAction()
    {
        list(, $form) = $this->getForm();

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Template(template="KPhoenContactBundle:Contact:contact.html.twig")
     */
    public function contactSendAction(Request $request)
    {
        list($message, $form) = $this->getForm();
        $form->bind($request);

        if ($form->isValid()) {
            $event = new ContactEvent($message);

            $this->get('event_dispatcher')->dispatch(ContactEvents::PRE_MESSAGE_SEND, $event);

            if ($event->getReceiver() === null) {
                return $this->redirectError('Impossible to determine the receiver');
            }

            if ($event->getSender() === null) {
                return $this->redirectError('Impossible to determine the sender');
            }

            if ($event->getSwiftMessage() === null) {
                return $this->redirectError('The Swift_Message instance has not been built');
            }

            $this->get('mailer')->send($event->getSwiftMessage());
            $this->get('event_dispatcher')->dispatch(ContactEvents::POST_MESSAGE_SEND, $event);

            $this->get('session')->getFlashBag()->add('notice', $this->translate('contact.submit.success'));

            return $this->redirect($this->generateUrl($this->container->getParameter('kphoen_contact.redirect_url')));
        }

        return array(
            'form' => $form->createView()
        );
    }

    protected function getForm()
    {
        $message = new Message();
        $form = $this->createForm('contact_message', $message, array(
            'translation_domain' => 'KPhoenContactBundle'
        ));

        return array($message, $form);
    }

    protected function translate($key, $args = array())
    {
        return $this->get('translator')->trans($key, $args, 'KPhoenContactBundle');
    }

    protected function redirectError($errorMsg)
    {
        $this->get('logger')->crit('[ContactBundle] '.$errorMsg);

        $this->get('session')->getFlashBag()->add('error', $this->translate('contact.submit.error'));
        return $this->redirect($this->generateUrl($this->container->getParameter('kphoen_contact.redirect_url')));
    }
}
