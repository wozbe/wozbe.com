<?php

namespace Wozbe\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Wozbe\BlogBundle\Entity\Post;
use Wozbe\BlogBundle\Entity\Comment;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @param string $username
     * @param string $email
     * @param string $content
     * 
     * @return \Wozbe\BlogBundle\Entity\Comment
     */
    public function addComment(Post $post, $username, $email, $content)
    {
        $comment = new Comment();
        $comment->setUsername($username);
        $comment->setEmail($email);
        $comment->setContent($content);
        $comment->setPost($post);
        
        $post->addComment($comment);
        
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
        
        return $comment;
    }
    
    public function findByPost(Post $post)
    {
        return $this->findBy(array('post' => $post));
    }
}
