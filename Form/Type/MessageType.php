<?php

namespace KPhoen\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sender_name', TextType::class, [
            'label' => 'contact.form.sender_name',
        ]);
        $builder->add('sender_mail', EmailType::class, [
            'label' => 'contact.form.sender_mail',
        ]);
        $builder->add('subject', TextType::class, [
            'label' => 'contact.form.subject',
        ]);
        $builder->add('content', TextareaType::class, [
            'label' => 'contact.form.content',
        ]);
    }

    public function getBlockPrefix() : string
    {
        return 'message';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = array(
            'data_class' => 'KPhoen\ContactBundle\Model\Message',
        );
        if ($resolver->isDefined('csrf_token_id')) {
            $defaults['csrf_token_id'] = 'contact';
        } else {
            $defaults['intention'] = 'contact';
        }

        $resolver->setDefaults($defaults);
    }
}
