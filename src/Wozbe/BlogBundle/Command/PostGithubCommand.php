<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

/**
 * Command for creating new post github.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
abstract class PostGithubCommand extends ContainerAwareCommand
{
    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubManager
     */
    protected function getPostGithubManager()
    {
        return $this->getContainer()->get('wozbe_blog.manager.post_github');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostRepository
     */
    protected function getPostRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Post');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubRepository
     */
    protected function getPostGithubRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:PostGithub');
    }
    
    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
}