<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating new post github.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostGithubDeleteCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post_github:delete')
            ->setDescription('Delete post github.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        
        $slug = $dialog->ask($output, $dialog->getQuestion('Post slug', null));
        
        $post = $this->getPostRepository()->findOneBySlug($slug);
        $postGithub = $this->getPostGithubRepository()->getPostGithubWithPost($post);
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you want to confirme suppresion', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getPostGithubManager()->deletePostGithub($postGithub);
        
        $output->writeln('done!');
    }
}