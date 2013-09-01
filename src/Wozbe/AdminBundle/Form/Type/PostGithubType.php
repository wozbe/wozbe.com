<?php

namespace Wozbe\AdminBundle\Form\Type;

use Wozbe\BlogBundle\Form\Type\PostGithubType as PostGithubTypeBase;

class PostGithubType extends PostGithubTypeBase
{
    public function getName()
    {
        return 'wozbe_admin_post_github_type';
    }
}
