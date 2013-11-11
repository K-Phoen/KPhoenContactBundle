<?php

namespace KPhoen\ContactBundle\Form\Handler;

use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\EventDispatcher\Event\ContactEvent;
use KPhoen\ContactBundle\Model\Message;

class ContactFormHandler
{
    protected $form;
    protected $dispatcher;
    protected $mailer;

    public function __construct(FormInterface $form, EventDispatcherInterface $eventDispatcher, Swift_Mailer $mailer)
    {
        $this->form = $form;
        $this->dispatcher = $eventDispatcher;
        $this->mailer = $mailer;
    }

    public function handle(Request $request, Message $message)
    {
        $this->form->bind($request);

        if (!$this->form->isValid()) {
            return false;
        }

        $event = new ContactEvent($request, $message);

        $this->dispatch(ContactEvents::PRE_MESSAGE_SEND, $event);

        if ($event->getReceiver() === null) {
            throw new \RuntimeException('Impossible to determine the receiver');
        }

        if ($event->getSender() === null) {
            throw new \RuntimeException('Impossible to determine the sender');
        }

        if ($event->getSwiftMessage() === null) {
            throw new \RuntimeException('The Swift_Message instance has not been built');
        }

        $this->mailer->send($event->getSwiftMessage());
        $this->dispatch(ContactEvents::POST_MESSAGE_SEND, $event);

        return true;
    }

    protected function dispatch($eventName, $event)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }
}
