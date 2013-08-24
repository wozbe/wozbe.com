<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for deleting comment.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentDeleteCommand extends CommentCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:comment:delete')
            ->setDescription('Delete comment.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $comment = $this->getComment($input, $output);
        
        if(!$comment) {
            return 1;
        }
        
        $output->writeln('');
        $output->writeln('Comment information:');
        $output->writeln(sprintf('<info>Post</info> : %s', $comment->getPost()->getTitle()));
        $output->writeln(sprintf('<info>Username</info> : %s', $comment->getUsername()));
        $output->writeln(sprintf('<info>Email</info> : %s', $comment->getEmail()));
        $output->writeln(sprintf('<info>Website</info> : %s', $comment->getWebsite()));
        
        $dialog = $this->getDialogHelper();
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm comment suppresion', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getCommentManager()->deleteCommand($comment);
        
        $output->writeln('done!');
    }
}