<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    private $options = array();

    public function __construct($environment, $debug, array $options = array())
    {
        parent::__construct($environment, $debug);
        $this->options = array_merge_recursive($this->options, $options);
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Wozbe\PageBundle\WozbePageBundle(),
            new Wozbe\RedirectBundle\WozbeRedirectBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
            new Presta\SitemapBundle\PrestaSitemapBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Wozbe\BlogBundle\WozbeBlogBundle(),
            new Wozbe\AdminBundle\WozbeAdminBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir()
    {
        if (isset($this->options['cache_dir'])) {
            $cacheDir = $this->options['cache_dir'];
        } else {
            $cacheDir = parent::getCacheDir();
        }

        return $cacheDir;

        if (in_array($this->environment, array('dev', 'test'))) {
            return '/dev/shm/symfony/cache/' .  $this->environment;
        }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        if (isset($this->options['log_dir'])) {
            $cacheDir = $this->options['log_dir'];
        } else {
            $cacheDir = parent::getLogDir();
        }

        return $cacheDir;

        if (in_array($this->environment, array('dev', 'test'))) {
            return '/dev/shm/symfony/logs';
        }

        return parent::getLogDir();
    }
}
