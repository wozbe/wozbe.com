<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Wozbe\BlogBundle\Entity\Post;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostInformationCommand extends PostCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post:information')
            ->setDescription('Get information about a post or about all posts.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->getPost($input, $output, false);
        
        if($post) {
            $this->displayPostInformation($post, $output);
        }
        else {
            $postRepository = $this->getContainer()->get('doctrine')->getRepository('WozbeBlogBundle:Post');
            $this->displayPostsInformation($postRepository->findAll(), $output);
        }
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
    }
    
    protected function displayPostsInformation(array $posts, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln(sprintf('<info>Posts</info> : %d', count($posts)));
    }
}