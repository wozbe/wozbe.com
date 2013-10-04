<?php

namespace Wozbe\AdminBundle\Entity;

use Wozbe\AdminBundle\Entity\Configuration;
use Wozbe\AdminBundle\Entity\ConfigurationRepository;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * ConfigurationManager
 */
class ConfigurationManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;
    
    /**
     * @var \Wozbe\AdminBundle\Entity\ConfigurationRepository
     */
    protected $configurationRepository;
    
    public function __construct(ObjectManager $objectManager, ConfigurationRepository $configurationRepository) 
    {
        $this->objectManager = $objectManager;
        $this->configurationRepository = $configurationRepository;
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * 
     * @return \Wozbe\AdminBundle\Entity\ConfigurationManager
     */
    public function set($name, $value)
    {
        // TODO Work on it
        $valueEncoded = json_encode($value);
        
        $configuration = $this->getConfigurationRepository()->findOneByName($name);
        
        if($configuration) {
            $configuration->setValue($valueEncoded);
            
            $this->add($configuration);
            
            return $this;
        }
        
        $this->add($this->build($name, $valueEncoded));
        
        return $this;
    }
    
    /**
     * @param string $name
     * 
     * @return mixed
     */
    public function get($name)
    {
        $configuration = $this->getConfigurationRepository()->findOneByName($name);
        
        if(!$configuration) {
            throw new \RuntimeException('Configuration does not exists');
        }
        
        return json_decode($configuration->getValue());
    }
    
    /**
     * 
     * @param \Wozbe\AdminBundle\Entity\Configuration $configuration
     * @return \Wozbe\AdminBundle\Entity\ConfigurationManager
     */
    protected function add(Configuration $configuration)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->persist($configuration);
        $objectManager->flush();
        
        return $configuration;
    }
    
    /**
     * 
     * @param \Wozbe\AdminBundle\Entity\Configuration $configuration
     * @return \Wozbe\AdminBundle\Entity\ConfigurationManager
     */
    protected function delete(Configuration $configuration)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->remove($configuration);
        $objectManager->flush();
        
        return $this;
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * 
     * @return \Wozbe\AdminBundle\Entity\ConfigurationManager
     */
    protected function build($name, $value)
    {
        $configuration = new Configuration($name, $value);
        
        return $configuration;
    }
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
    
    /**
     * @return \Wozbe\AdminBundle\Entity\ConfigurationRepository
     */
    protected function getConfigurationRepository()
    {
        return $this->configurationRepository;
    }
        
}
