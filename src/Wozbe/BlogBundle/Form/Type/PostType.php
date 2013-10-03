<?php

namespace Wozbe\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'Title'
            ))
            ->add('slug', 'text', array(
                'required' => true,
                'label' => 'slug'
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'Description'
            ))
            ->add('published', 'checkbox', array(
                'required' => false,
                'label' => 'Published'
            ))
            ->add('content', 'textarea', array(
                'required' => false,
                'label' => 'Content',
            ))
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wozbe\BlogBundle\Entity\Post',
        ));
    }

    public function getName()
    {
        return 'wozbe_post_type';
    }
}
