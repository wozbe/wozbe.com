<?php

namespace Wozbe\AdminBundle\Form\Type;

use Wozbe\BlogBundle\Form\Type\PostType as PostTypeBase;


class PostType extends PostTypeBase
{
    public function getName()
    {
        return 'wozbe_admin_post_type';
    }
}
