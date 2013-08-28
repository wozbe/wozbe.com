<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

use Wozbe\BlogBundle\Entity\Comment;

/**
 * Abstract Command provided with some blog features
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
abstract class AbstractCommand extends ContainerAwareCommand
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
    
    protected function displayCommentInformation(OutputInterface $output, Comment $comment)
    {
        $output->writeln('');
        $output->writeln('Comment information:');
        $output->writeln(sprintf('<info>Post</info> : %s', $comment->getPost()->getTitle()));
        $output->writeln(sprintf('<info>Username</info> : %s', $comment->getUsername()));
        $output->writeln(sprintf('<info>Email</info> : %s', $comment->getEmail()));
        $output->writeln(sprintf('<info>Website</info> : %s', $comment->getWebsite()));
        $output->writeln(sprintf('<info>Content</info> : %s', $comment->getContent()));
        $output->writeln('');
    }
    
    protected function displayPostInformation(Post $post, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln(sprintf('<info>Title</info> : %s', $post->getTitle()));
        $output->writeln(sprintf('<info>Description</info> : %s', $post->getDescription()));
        $output->writeln(sprintf('<info>Slug</info> : %s', $post->getSlug()));
        $output->writeln(sprintf('<info>Published</info> : %s', $post->getPublished() ? 'yes': 'no'));
        $output->writeln(sprintf('<info>Created At</info> : %s', $post->getCreatedAt()->format('Y-m-d H:i:s')));
        $output->writeln(sprintf('<info>Modified At</info> : %s', $post->getModifiedAt()->format('Y-m-d H:i:s')));
        $output->writeln(sprintf('<info>Tags</info> : %d', count($post->getTags())));
        $output->writeln(sprintf('<info>Comments</info> : %d', count($post->getComments())));
        $output->writeln('');
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
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    protected function getCommentManager()
    {
        return $this->getContainer()->get('wozbe_blog.manager.comment');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\CommentRepository
     */
    protected function getCommentRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Comment');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    protected function getPostManager()
    {
        return $this->getContainer()->get('wozbe_blog.manager.post');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostRepository
     */
    protected function getPostRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Post');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubManager
     */
    protected function getPostGithubManager()
    {
        return $this->getContainer()->get('wozbe_blog.manager.post_github');
    }
    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubRepository
     */
    protected function getPostGithubRepository()
    {
        return $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:PostGithub');
    }
}