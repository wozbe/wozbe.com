<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for publish comment.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class CommentPublishCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:comment:publish')
            ->setDescription('Publish comment.')
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
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm comment publication', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getCommentManager()->publish($comment);
        
        $output->writeln('done!');
    }
}