<?php

namespace KPhoen\ContactBundle\EventDispatcher\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

use KPhoen\ContactBundle\EventDispatcher\ContactEvents;
use KPhoen\ContactBundle\EventDispatcher\Event\ContactEvent;

class MessageBuilderListener implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(TranslatorInterface $translator, EngineInterface $templating)
    {
        $this->translator = $translator;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return [
            ContactEvents::PRE_MESSAGE_SEND => ['preSend', -255],
        ];
    }

    public function preSend(ContactEvent $event)
    {
        if ($event->getSwiftMessage() !== null || $event->getReceiver() === null || $event->getSender() === null) {
            return;
        }

        $event->setSwiftMessage($this->buildSwiftMessage($event));
    }

    protected function buildSwiftMessage(ContactEvent $event)
    {
        $message = $event->getMessage();
        $translatorArgs = [
            '%sender_name%' => $message->sender_name,
            '%sender_mail%' => $message->sender_mail,
            '%subject%'     => $message->subject,
            '%content%'     => $message->content,
        ];
        $templateArgs = ['event' => $event, 'message' => $message];

        $swiftMessage = new \Swift_Message($this->translate($message->subject, $translatorArgs));

        $swiftMessage->addFrom($event->getSender());
        $swiftMessage->addTo($event->getReceiver());
        $swiftMessage->addReplyTo($message->sender_mail, $message->sender_name);
        $swiftMessage->addPart(
            $this->render('KPhoenContactBundle:Mails:mail.html.twig', $templateArgs),
            'text/html'
        );
        $swiftMessage->addPart(
            $this->render('KPhoenContactBundle:Mails:mail.txt.twig', $templateArgs),
            'text/plain'
        );

        return $swiftMessage;
    }

    protected function translate($key, $args = [])
    {
        return $this->translator->trans($key, $args, 'KPhoenContactBundle');
    }

    protected function render($template, $args = [])
    {
        return $this->templating->render($template, $args);
    }
}
