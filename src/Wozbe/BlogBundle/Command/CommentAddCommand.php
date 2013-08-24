<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

use Wozbe\BlogBundle\Entity\PostFactory;

/**
 * Command for creating new comment.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentAddCommand extends CommentCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:comment:add')
            ->setDescription('Add comment.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $post = $this->getPost($input, $output);
        
        if(!$post) {
            return 1;
        }
        
        $dialog = $this->getDialogHelper();
        
        $username = $dialog->ask($output, $dialog->getQuestion('Comment username', null));
        $email = $dialog->ask($output, $dialog->getQuestion('Comment email', null));
        $content = $dialog->ask($output, $dialog->getQuestion('Comment content', null));
        
        $this->getCommentRepository()->addComment($post, $username, $email, $content);
        
        $output->writeln('done!');
    }
}