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
    public function deletePost(Post $post)
    {
        // TODO - Cascade delete for comments
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
    public function addPost($title, $slug, $content = null, $description = null)
    {
        $postFactory = new PostFactory();
        $post = $postFactory->createPost($title, $slug, $content, $description);
        
        $this->savePost($post);
        
        return $this;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function savePost(Post $post)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->persist($post);
        $objectManager->flush();
        
        return $this;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function publishPost(Post $post)
    {
        $post->setPublished(true);
        
        $this->getObjectManager()->flush();
        
        return $this;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    public function unpublishPost(Post $post)
    {
        $post->setPublished(false);
        
        $this->getObjectManager()->flush();
        
        return $this;
    }
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
        
}
