<?php

namespace Wozbe\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PostGithubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('owner', 'text', array(
                'required' => true,
                'label' => 'Title'
            ))
            ->add('repo', 'text', array(
                'required' => true,
                'label' => 'slug'
            ))
            ->add('path', 'textarea', array(
                'required' => false,
                'label' => 'Description'
            ))
            ->add('save', 'submit', array('label' => 'Save'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wozbe\BlogBundle\Entity\PostGithub',
        ));
    }

    public function getName()
    {
        return 'wozbe_post_github_type';
    }
}
