<?php

namespace Wozbe\AdminBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

use Wozbe\AdminBundle\Entity\Configuration;

/**
 * Install website
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wozbe:install')
            ->setDescription('Install wozbe.')
            ->addOption(
                'default',
                'd',
                InputOption::VALUE_NONE,
                'Use default values'
            )
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurationManager = $this->getContainer()->get('wozbe_admin.manager.configuration');
        $dialog = $this->getDialogHelper();
        
        $explanationList = array(
            'blog.comment.enabled' => array(
                'question' => 'Do you want to enabled comment',
                'type' => 'boolean',
                'default' => false,
            ),
            'page.email' => array(
                'question' => 'Email',
                'type' => 'string',
                'default' => 'contact@wozbe.com',
            ),
            'page.phone' => array(
                'question' => 'Phone number',
                'type' => 'number',
                'default' => '0953203344',
            ),
        );
        
        foreach($explanationList as $name => $explanation) {
            if($input->getOption('default')) {
                $configurationManager->set($name, $explanation['default']);
                continue;
            }

            switch($explanation['type']) {
                case 'boolean' : 
                    $value = $dialog->askConfirmation($output, $dialog->getQuestion($explanation['question'], 'yes', '?'), true);
                    break;
                default :
                    $value = $dialog->ask($output, $dialog->getQuestion($explanation['question'], null));
            }
            
            $configurationManager->set($name, $value);
        }
        
        $output->writeln('done!');
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