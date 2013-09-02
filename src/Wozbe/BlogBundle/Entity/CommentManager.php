<?php

namespace Wozbe\BlogBundle\Entity;

use Wozbe\BlogBundle\Entity\Comment;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * CommentManager
 */
class CommentManager
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
     * @param \Wozbe\BlogBundle\Entity\Comment $comment
     * @return \Wozbe\BlogBundle\Entity\Comment
     */
    public function add(Comment $comment)
    {
        $this->getObjectManager()->persist($comment);
        $this->getObjectManager()->flush();
        
        return $comment;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Comment $comment
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    public function remove(Comment $comment)
    {
        $objectManager = $this->getObjectManager();
        $objectManager->remove($comment);
        $objectManager->flush();
        
        return $comment;
    }
    
    /**
     * Build and save comment
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @param string $username
     * @param string $email
     * @param string $content
     * 
     * @return \Wozbe\BlogBundle\Entity\Comment
     */
    public function build(Post $post, $username = null, $email = null, $website = null, $content = null)
    {
        $comment = new Comment();
        $comment->setUsername($username);
        $comment->setEmail($email);
        $comment->setWebsite($website);
        $comment->setContent($content);
        $comment->setPost($post);
        
        $post->addComment($comment);
        
        return $comment;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Comment $comment
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    public function publish(Comment $comment)
    {
        $comment->setPublished(true);
        
        $this->getObjectManager()->flush();
        
        return $comment;
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Comment $comment
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    public function unpublish(Comment $comment)
    {
        $comment->setPublished(false);
        
        $this->getObjectManager()->flush();
        
        return $comment;
    }
    
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
}
