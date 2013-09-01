<?php

namespace Wozbe\BlogBundle\Entity;

use Wozbe\BlogBundle\Entity\Post;

/**
 * PostGithub
 */
class PostGithub
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $path;

    /**
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * @var \Wozbe\BlogBundle\Entity\Post
     */
    private $post;
    
    public function __construct(Post $post, $owner, $repo, $path) 
    {
        $this->post = $post;
        $this->owner = $owner;
        $this->repo = $repo;
        $this->path = $path;
        
        $this->updated();
    }
    
    public function updated()
    {
        $this->updatedAt = new \DateTime();
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
     * Set path
     *
     * @param string $path
     * @return PostGithub
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return PostGithub
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set post
     *
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return PostGithub
     */
    public function setPost(\Wozbe\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;
    
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

    /**
     * Set owner
     *
     * @param string $owner
     * @return PostGithub
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set repo
     *
     * @param string $repo
     * @return PostGithub
     */
    public function setRepo($repo)
    {
        $this->repo = $repo;
    
        return $this;
    }

    /**
     * Get repo
     *
     * @return string 
     */
    public function getRepo()
    {
        return $this->repo;
    }
}