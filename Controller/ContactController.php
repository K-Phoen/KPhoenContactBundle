<?php

namespace KPhoen\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use KPhoen\ContactBundle\Form\Type\MessageType;
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
        $form->bindRequest($request);

        if ($form->isValid()) {
            $message->send($this->get('mailer'), $this->container->getParameter('kphoen_contact.to'));

            $this->get('session')->setFlash('notice', 'Mail envoyé !');

            return $this->redirect($this->generateUrl($this->container->getParameter('kphoen_contact.redirect_url')));
        }

        return array(
            'form' => $form->createView()
        );
    }

    protected function getForm()
    {
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);

        return array($message, $form);
    }
}
