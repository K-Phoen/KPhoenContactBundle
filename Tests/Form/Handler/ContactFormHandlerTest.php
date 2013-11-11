<?php

namespace KPhoen\ContactBundle\Tests\Form\Handler;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\Form\Handler\ContactFormHandler;
use KPhoen\ContactBundle\Model\Message;

class ContactFormHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleWithInvalidForm()
    {
        $handler = new ContactFormHandler($this->getForm(false), $this->getDispatcher(), $this->getMailer());

        $this->assertFalse($handler->handle($this->getRequest(), new Message()));
    }

    /**
     * @expectedException           RuntimeException
     * @expectedExceptionMessage    Impossible to determine the receiver
     */
    public function testHandleWithNoReceiver()
    {
        $handler = new ContactFormHandler($this->getForm(true), $this->getDispatcher(), $this->getMailer());
        $handler->handle($this->getRequest(), new Message());
    }

    /**
     * @expectedException           RuntimeException
     * @expectedExceptionMessage    Impossible to determine the sender
     */
    public function testHandleWithNoSender()
    {
        $dispatcher = $this->getDispatcher();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                ContactEvents::PRE_MESSAGE_SEND,
                $this->callback(function($event) {
                    $event->setReceiver('lala');
                    return true;
                })
            );

        $handler = new ContactFormHandler($this->getForm(true), $dispatcher, $this->getMailer());
        $handler->handle($this->getRequest(), new Message());
    }

    /**
     * @expectedException           RuntimeException
     * @expectedExceptionMessage    The Swift_Message instance has not been built
     */
    public function testHandleWithNoSwiftMessage()
    {
        $dispatcher = $this->getDispatcher();
        $dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                ContactEvents::PRE_MESSAGE_SEND,
                $this->callback(function($event) {
                    $event->setReceiver('lala');
                    $event->setSender('lala');
                    return true;
                })
            );

        $handler = new ContactFormHandler($this->getForm(true), $dispatcher, $this->getMailer());
        $handler->handle($this->getRequest(), new Message());
    }

    public function testHandle()
    {
        $swiftMessage = $this->getMockBuilder('\Swift_Message')->disableOriginalConstructor()->getMock();;
        $dispatcher = $this->getDispatcher();
        $dispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with(
                ContactEvents::PRE_MESSAGE_SEND,
                $this->callback(function($event) use ($swiftMessage) {
                    $event->setReceiver('lala');
                    $event->setSender('lala');
                    $event->setSwiftMessage($swiftMessage);
                    return true;
                })
            );
        $dispatcher
            ->expects($this->at(1))
            ->method('dispatch')
            ->with(ContactEvents::POST_MESSAGE_SEND, $this->anything());

        $mailer = $this->getMailer();
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($swiftMessage));

        $handler = new ContactFormHandler($this->getForm(true), $dispatcher, $mailer);
        $this->assertTrue($handler->handle($this->getRequest(), new Message()));
    }

    protected function getMailer()
    {
        return $this->getMockBuilder('\Swift_Mailer')
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getDispatcher()
    {
        return $this->getMock('\Symfony\Component\EventDispatcher\EventDispatcherInterface');
    }

    protected function getForm($valid = true)
    {
        $form = $this->getMockBuilder('\Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock();

        $form
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue($valid));

        return $form;
    }

    protected function getRequest()
    {
        return $this->getMock('\Symfony\Component\HttpFoundation\Request');
    }
}
