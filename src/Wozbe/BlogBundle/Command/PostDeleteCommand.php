<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostDeleteCommand extends PostCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post:delete')
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
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm post suppresion', 'yes', '?'), true)) {
            return 1;
        }
        
        $objectManager = $this->getObjectManager();
        $objectManager->remove($post);
        $objectManager->flush();
        
        $output->writeln('done!');
    }
}