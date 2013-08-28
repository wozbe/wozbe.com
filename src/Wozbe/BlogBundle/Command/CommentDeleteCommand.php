<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for deleting comment.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentDeleteCommand extends AbstractCommand
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
        
        $this->displayCommentInformation($output, $comment);
        
        $dialog = $this->getDialogHelper();
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm comment suppresion', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getCommentManager()->deleteComment($comment);
        
        $output->writeln('done!');
    }
}