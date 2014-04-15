<?php
namespace Wozbe\AdminBundle\Twig\Extension;

use Wozbe\AdminBundle\Entity\ConfigurationManagerInterface;

class ConfigurationExtension extends \Twig_Extension
{
    /**
     * @var \Wozbe\AdminBundle\Entity\ConfigurationManagerInterface
     */
    protected $configurationManager;
    
    public function __construct(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }
    
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return array(
            'config' => new \Twig_Function_Method($this, 'getConfiguration'),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wozbe_configuration';
    }
    
    public function getConfiguration($name)
    {
        return $this->configurationManager->get($name);
    }
}
