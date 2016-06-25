<?php

namespace KPhoen\ContactBundle\EventDispatcher\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\EventDispatcher\Event\ContactEvent;
use KPhoen\ContactBundle\Strategy\Strategy;

class ReceiverListener implements EventSubscriberInterface
{
    protected $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactEvents::PRE_MESSAGE_SEND => 'preSend',
        ];
    }

    public function preSend(ContactEvent $event)
    {
        $event->setReceiver($this->strategy->getAddress($event->getRequest()));
    }
}
