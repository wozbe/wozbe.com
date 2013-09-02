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
        
        $post = $this->getPost($input, $output);
        
        if(!$post) {
            $output->writeln('Post not found');
            return 1;
        }
        
        $slug = $post->getSlug();
        
        $postGithub = $this->getPostGithubRepository()->getPostGithubWithPost($post);
        
        if (!$postGithub) {
            $output->writeln(sprintf('Post <info>%s</info> is not github linked', $slug));
            return 1;
        }
        
        if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm PostGithub suppresion', 'yes', '?'), true)) {
            return 1;
        }
        
        $this->getPostGithubManager()->delete($postGithub);
        
        $output->writeln('done!');
    }
}