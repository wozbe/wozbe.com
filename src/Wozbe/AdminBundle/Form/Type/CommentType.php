<?php

namespace Wozbe\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use Wozbe\BlogBundle\Form\Type\CommentType as CommentTypeBase;

class CommentType extends CommentTypeBase
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('published', 'checkbox', array(
                'required' => false,
                'label' => 'Published'
            ))
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }
    
    public function getName()
    {
        return 'wozbe_admin_comment_type';
    }
}
