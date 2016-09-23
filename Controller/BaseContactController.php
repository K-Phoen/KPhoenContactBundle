<?php

namespace KPhoen\ContactBundle\Controller;

use KPhoen\ContactBundle\Form\Type\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use KPhoen\ContactBundle\Form\Handler\ContactFormHandler;
use KPhoen\ContactBundle\Model\Message;

abstract class BaseContactController extends Controller
{
    protected function handleContactForm(Request $request, FormInterface $form, Message $message)
    {
        $handler = new ContactFormHandler($form, $this->get('event_dispatcher'), $this->get('mailer'));

        try {
            $valid = $handler->handle($request, $message);
        } catch (\RuntimeException $e) {
            return $this->redirectError($e->getMessage());
        }

        if (!$valid) {
            return;
        }

        $this->get('session')->getFlashBag()->add('notice', $this->translate('contact.submit.success'));

        return $this->redirect($this->generateUrl($this->container->getParameter('kphoen_contact.redirect_url')));
    }

    protected function getContactForm() : array
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message, array(
            'translation_domain' => 'KPhoenContactBundle',
        ));

        return [$message, $form];
    }

    protected function translate(string $key, array $args = array()) : string
    {
        return $this->get('translator')->trans($key, $args, 'KPhoenContactBundle');
    }

    protected function redirectError(string $errorMsg) : \Symfony\Component\HttpFoundation\Response
    {
        $this->get('logger')->crit('[ContactBundle] '.$errorMsg);
        $this->get('session')->getFlashBag()->add('error', $this->translate('contact.submit.error'));

        return $this->redirect($this->generateUrl($this->container->getParameter('kphoen_contact.redirect_url')));
    }
}
