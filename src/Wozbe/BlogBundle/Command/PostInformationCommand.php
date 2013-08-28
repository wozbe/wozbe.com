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
class PostInformationCommand extends AbstractCommand
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
            
            $posts = $postRepository->findAll();
            
            foreach($posts as $post) {
                $this->displayPostInformation($post, $output);
            }
        }
    }
}