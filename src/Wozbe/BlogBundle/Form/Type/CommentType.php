<?php

namespace Wozbe\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('username', null, array(
                'required' => true,
                'label' => 'Username'
            ))
            ->add('email', null, array(
                'required' => true,
                'label' => 'Email'
            ))
            ->add('website', null, array(
                'required' => true,
                'label' => 'Website'
            ))
            ->add('content', 'textarea', array(
                'required' => true,
                'label' => 'Content',
                'read_only' => false
            ))
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wozbe\BlogBundle\Entity\Comment',
        ));
    }

    public function getName()
    {
        return 'wozbe_comment_type';
    }
}
