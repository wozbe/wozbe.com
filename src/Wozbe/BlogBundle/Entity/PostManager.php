<?php

namespace Wozbe\BlogBundle\Entity;

use Wozbe\BlogBundle\Entity\Post;
use Wozbe\BlogBundle\Entity\PostFactory;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * PostManager
 */
class PostManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;
    
    public function __construct(ObjectManager $objectManager) 
    {
        $this->objectManager = $objectManager;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function add(Post $post)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->persist($post);
        $objectManager->flush();
        
        return $post;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function delete(Post $post)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->remove($post);
        $objectManager->flush();
        
        return $this;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function build($title, $slug, $content = null, $description = null)
    {
        $postFactory = new PostFactory();
        $post = $postFactory->createPost($title, $slug, $content, $description);
        
        return $post;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function publish(Post $post)
    {
        $post->setPublished(true);
        
        $this->getObjectManager()->flush();
        
        return $post;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function unpublish(Post $post)
    {
        $post->setPublished(false);
        
        $this->getObjectManager()->flush();
        
        return $post;
    }
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
        
}
