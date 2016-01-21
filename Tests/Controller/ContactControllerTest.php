<?php

namespace KPhoen\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ContactControllerTest extends WebTestCase
{
    public function testContact()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            1, $crawler->filter('h2:contains("Contact")')->count()
        );

        $form = $crawler->selectButton('kphoen_contact_submit')->form();

        $form->get('message[sender_name]')->setValue('Joe');
        $form->get('message[sender_mail]')->setValue('joe@joe.fr');

        // submit the form
        $crawler = $client->submit($form);

        // there is an error so the user is not redirected
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotInstanceOf('Symfony\\Component\\HttpFoundation\\RedirectResponse', $client->getResponse());

        // no mail was sent
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(0, $collector->getMessageCount());

        $form = $crawler->selectButton('kphoen_contact_submit')->form();
        $form->setValues([
            'message[sender_name]'  => 'Joe',
            'message[sender_mail]'  => 'joe@joe.fr',
            'message[subject]'      => 'test subject',
            'message[content]'      => 'test content !',
        ]);

        $crawler = $client->submit($form);

        // this time, as there is no error, the user is redirected
        $this->assertTrue($client->getResponse()->isRedirect('/contact'), 'The user is redirected to the right place');

        // a mail was sent
        $collector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $collector->getMessageCount());

        // the mail is well-formed
        list($mail) = $collector->getMessages();

        $this->assertTrue($mail instanceof \Swift_Message);
        $this->assertContains('test content !', (string) $mail);
        $this->assertEquals(['foo@bar.baz' => ''], $mail->getTo());
        $this->assertEquals(['no-reply@bar.baz' => ''], $mail->getFrom());
        $this->assertEquals(['joe@joe.fr' => 'Joe'], $mail->getReplyTo());
        $this->assertEquals('test subject', $mail->getSubject());
    }
}
