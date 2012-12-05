<?php

namespace KPhoen\ContactBundle\Model;


/**
 * This class represents a message.
 */
class Message
{
    public $sender_name;
    public $sender_mail;
    public $subject;
    public $content;


    public function send($mailer, $to)
    {
        $message = \Swift_Message::newInstance()
            ->setTo($to)
            ->setSubject($this->subject)
            ->setFrom(array($this->sender_mail => $this->sender_name))
            ->setBody($this->content, 'text/html');

        // and send the mail
        $mailer->send($message);
    }
} // Message
