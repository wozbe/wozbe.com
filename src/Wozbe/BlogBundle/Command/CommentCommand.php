<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
abstract class CommentCommand extends ContainerAwareCommand
{
    /**
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * 
     * @return \Wozbe\BlogBundle\Entity\Post
     */
    protected function getPost(InputInterface $input, OutputInterface $output, $displayError = true)
    {
        $postRepository = $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Post');
        $posts = $postRepository->findAll();
        
        $slugs = array();
        
        array_walk($posts, function($value) use (&$slugs) {
            $slugs[] = $value->getSlug();
        });
        
        $dialog = $this->getDialogHelper();
        
        $slug = $dialog->ask($output, $dialog->getQuestion('Select a post slug', null), null, $slugs);

        $post = $postRepository->findOneBy(array('slug' => $slug));
        
        if(!$post && $displayError) {
            $output->writeln(sprintf('<error>Slug is not found : %s</error>', $slug));
        }
        
        return $post;
    }
    
    /**
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * 
     * @return \Wozbe\BlogBundle\Entity\Comment
     */
    protected function getComment(InputInterface $input, OutputInterface $output, $displayError = true)
    {
        $dialog = $this->getDialogHelper();
        
        $id = $dialog->ask($output, $dialog->getQuestion('Select a comment id', null), null);

        $comment = $this->getCommentRepository()->findOneBy(array('id' => $id));
        
        if(!$comment && $displayError) {
            $output->writeln(sprintf('<error>Comment is not found : %d</error>', $id));
        }
        
        return $comment;
    }
    
    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
    
    /**
     * 
     * @return \Wozbe\BlogBundle\Entity\CommentRepository
     */
    protected function getCommentRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Comment');
    }
    
    protected function getObjectManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
}