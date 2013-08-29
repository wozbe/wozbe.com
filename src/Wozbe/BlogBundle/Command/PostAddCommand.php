<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostAddCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post:add')
            ->setDescription('Add post.')
            ->addOption('preferred-title', null, InputOption::VALUE_OPTIONAL, 'Preferred title.')
            ->addOption('preferred-slug', null, InputOption::VALUE_OPTIONAL, 'Preferred slug.')
            ->addOption('preferred-description', null, InputOption::VALUE_OPTIONAL, 'Preferred description.')
            ->addOption('content-from-file', null, InputOption::VALUE_OPTIONAL, 'When specified, use file to generate content.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        
        $postTitle = $dialog->ask($output, $dialog->getQuestion('Post title', $input->getOption('preferred-title')));
        $postSlug = $dialog->ask($output, $dialog->getQuestion('Post slug', $input->getOption('preferred-slug')));
        $postDescription = $dialog->ask($output, $dialog->getQuestion('Post description', $input->getOption('preferred-description')));
        $postContent = null;
        
        $contentFromFile = $input->getOption('content-from-file');
        if($contentFromFile) {
            if(!file_exists($contentFromFile)) {
                $output->writeln(sprintf('<error>File does not exists : %s</error>', $contentFromFile));

                return 1;
            }
            
            $postContent = file_get_contents($contentFromFile);
        }
        
        $post = $this->getPostManager()->addPost($postTitle, $postSlug, $postContent, $postDescription);
        
        if ($dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm post publication', 'yes', '?'), true)) {
            $this->getPostManager()->publishPost($post);
        }
        
        $output->writeln('done!');
    }
}