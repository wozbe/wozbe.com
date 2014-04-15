<?php

namespace Wozbe\AdminBundle\Entity;

/**
 * ConfigurationManager
 */
class ConfigurationDummyManager implements ConfigurationManagerInterface
{
    private $configurationList;

    public function __construct()
    {
        $this->configurationList    = array();
    }

    public function set($name, $value)
    {
        $this->configurationList[$name] = $value;

        return $this;
    }

    public function get($name)
    {
        if(isset($this->configurationList[$name])) {
            return $this->configurationList[$name];
        }

        return true;
    }
}
