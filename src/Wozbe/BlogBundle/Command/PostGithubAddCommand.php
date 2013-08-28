<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating new post github.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostGithubAddCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post_github:add')
            ->setDescription('Add post github.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        
        $slug = $dialog->ask($output, $dialog->getQuestion('Post slug', null));
        $owner = $dialog->ask($output, $dialog->getQuestion('Github owner', null));
        $repo = $dialog->ask($output, $dialog->getQuestion('Github repo', null));
        $path = $dialog->ask($output, $dialog->getQuestion('Github path', null));
        
        $post = $this->getPostRepository()->findOneBySlug($slug);
        
        $postGithub = $this->getPostGithubManager()->addPostGithub($post, $owner, $repo, $path);
        
        if ($dialog->askConfirmation($output, $dialog->getQuestion('Do you want to update content', 'yes', '?'), true)) {
            $this->getPostGithubManager()->updatePostFromGithub($postGithub);
        }
        
        $output->writeln('done!');
    }
}