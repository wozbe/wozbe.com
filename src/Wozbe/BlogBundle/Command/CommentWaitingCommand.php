<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to display comment waiting for approbation
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentWaitingCommand extends CommentCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:comment:waiting')
            ->setDescription('See waiting comment.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $comments = $this->getCommentRepository()->findUnpublished();
        
        $dialog = $this->getDialogHelper();
        
        foreach ($comments as $comment) {
            $this->displayCommentInformation($output, $comment);
            
            if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm comment publication', 'yes', '?'), true)) {
                
                if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you want to delete this comment', 'yes', '?'), true)) {
                    continue;
                }
                
                $this->getCommentManager()->deleteComment($comment);
            }

            $this->getCommentManager()->publishComment($comment);
        }
        
        $output->writeln('done!');
    }
}