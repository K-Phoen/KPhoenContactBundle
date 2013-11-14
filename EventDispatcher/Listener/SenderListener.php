<?php

namespace KPhoen\ContactBundle\EventDispatcher\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\EventDispatcher\Event\ContactEvent;
use KPhoen\ContactBundle\Strategy\Strategy;

class SenderListener implements EventSubscriberInterface
{
    protected $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ContactEvents::PRE_MESSAGE_SEND => 'preSend',
        );
    }

    public function preSend(ContactEvent $event)
    {
        $event->setSender($this->strategy->getAddress($event->getRequest()));
    }
}
