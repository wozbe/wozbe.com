<?php

namespace Wozbe\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Wozbe\BlogBundle\Entity\Comment;

/**
 * Post
 */
class Post
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $content;

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
    private $slug;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var array
     */
    private $comments;

    /**
     * @var integer
     */
    private $id;

    public function __construct() 
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
        $this->published = false;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        $this->modifiedAt = new \DateTime();
    
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
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return Post
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    
        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
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
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set tags
     *
     * @param array $tags
     * @return Post
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        
        $this->modifiedAt = new \DateTime();
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return array 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set comments
     *
     * @param array $comments
     * @return Post
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        
        return $this;
    }

    /**
     * Get comments
     *
     * @return array 
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        
        return $this;
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
}