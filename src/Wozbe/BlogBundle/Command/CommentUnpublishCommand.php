<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for unpublish comment.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentUnpublishCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:comment:unpublish')
            ->setDescription('Unpublish comment.')
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
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm comment unpublication', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getCommentManager()->unpublish($comment);
        
        $output->writeln('done!');
    }
}