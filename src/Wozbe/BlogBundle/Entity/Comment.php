<?php

namespace Wozbe\BlogBundle\Entity;

use Wozbe\BlogBundle\Entity\Post;

/**
 * Comment
 */
class Comment
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $website;

    /**
     * @var \DateTime
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \Wozbe\BlogBundle\Entity\Post
     */
    private $post;
    
    public function __construct() 
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
        $this->published = false;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Comment
     */
    public function setUsername($username)
    {
        $this->username = $username;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set website
     *
     * @param string $website
     * @return Comment
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set published
     *
     * @param boolean $published
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set post
     *
     * @param \Wozbe\BlogBundle\Entity\Post  $post
     * @return Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get post
     *
     * @return \Wozbe\BlogBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
