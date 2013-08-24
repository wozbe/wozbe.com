<?php

namespace Wozbe\BlogBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

use Wozbe\BlogBundle\Entity\PostFactory;

/**
 * Command for creating new post.
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class PostAddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:post:add')
            ->setDescription('Add post.')
            ->addOption('content-from-file', null, InputOption::VALUE_OPTIONAL, 'When specified, use file to generate content.')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        
        $postTitle = $dialog->ask($output, $dialog->getQuestion('Post title', null));
        $postSlug = $dialog->ask($output, $dialog->getQuestion('Post slug', null));
        $postContent = null;
        
        $contentFromFile = $input->getOption('content-from-file');
        if($contentFromFile) {
            if(!file_exists($contentFromFile)) {
                $output->writeln(sprintf('<error>File does not exists : %s</error>', $contentFromFile));

                return 1;
            }
            
            $postContent = file_get_contents($contentFromFile);
        }
        
        $postFactory = new PostFactory();
        $post = $postFactory->createPost($postTitle, $postSlug, $postContent);
        
        $objectManager = $this->getObjectManager();
        $objectManager->persist($post);
        $objectManager->flush();
        
        $output->writeln('done!');
    }
    
    protected function getObjectManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
}