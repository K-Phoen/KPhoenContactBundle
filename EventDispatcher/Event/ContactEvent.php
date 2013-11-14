<?php

namespace KPhoen\ContactBundle\EventDispatcher\Event;

use Swift_Message;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

use KPhoen\ContactBundle\Model\Message;

class ContactEvent extends Event
{
    /**
     * @var Swift_Message
     */
    protected $swiftMessage;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $receiver;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @param Contact $contact
     */
    public function __construct(Request $request, Message $message)
    {
        $this->request = $request;
        $this->message = $message;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Swift_Message $message
     */
    public function setSwiftMessage(Swift_Message $message)
    {
        $this->swiftMessage = $message;
    }

    /**
     * @return Swift_Message
     */
    public function getSwiftMessage()
    {
        return $this->swiftMessage;
    }

    /**
     * @param string $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param string $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }
}
