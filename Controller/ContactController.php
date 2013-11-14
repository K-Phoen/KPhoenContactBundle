<?php

namespace KPhoen\ContactBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends BaseContactController
{
    /**
     * @Template()
     */
    public function contactAction(Request $request)
    {
        list($message, $form) = $this->getContactForm();

        if ($request->isMethod('POST') && ($res = $this->handleContactForm($request, $form, $message)) !== null) {
            return $res;
        }

        return array(
            'form'          => $form->createView(),
            'route'         => 'contact_send',
            'route_args'    => array(),
        );
    }
}
