<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostPublishCommand extends PostCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post:publish')
            ->setDescription('Publish a post.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->getPost($input, $output);
        
        if(!$post) {
            return 1;
        }
        
        $dialog = $this->getDialogHelper();
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm post publication', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getContainer()->get('wozbe_blog.manager.post')->publishPost($post);
        
        $output->writeln('done!');
    }
}