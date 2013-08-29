<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

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
        
        $owner = $dialog->ask($output, $dialog->getQuestion('Github owner', null));
        $repo = $dialog->ask($output, $dialog->getQuestion('Github repo', null));
        
        $pathPostList = $this->getPostGithubManager()->listAvailablePathPostFromGithub($owner, $repo);
        
        $path = $dialog->ask($output, $dialog->getQuestion('Github path', null), null, $pathPostList);
        
        
        if ($dialog->askConfirmation($output, $dialog->getQuestion('Do you want to create a new post', 'yes', '?'), true)) {
            $addPostArguments = array(
                '',
                '--preferred-title' => $path,
                '--preferred-slug' => $path,
            );
            
            $command = $this->getApplication()->find('blog:post:add');
            $command->run(new ArrayInput($addPostArguments), $output);
        }
        
        $post = $this->getPost($input, $output);
        
        if(!$post) {
            $output->writeln('Post not found');
            return 1;
        }        
        
        
        $postGithub = $this->getPostGithubManager()->addPostGithub($post, $owner, $repo, $path);
        
        if ($dialog->askConfirmation($output, $dialog->getQuestion('Do you want to update content', 'yes', '?'), true)) {
            $this->getPostGithubManager()->updatePostFromGithub($postGithub);
        }
        
        $output->writeln('done!');
    }
}