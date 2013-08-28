<?php

namespace Wozbe\BlogBundle\Entity;

use Wozbe\BlogBundle\Entity\Post;

use Doctrine\ORM\EntityRepository;

/**
 * PostGithubRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostGithubRepository extends EntityRepository
{
    /**
     * 
     * @param string $owner
     * @param string $repo
     * @param string $path
     * @return \Wozbe\BlogBundle\Entity\PostGithub
     */
    public function getPostGithubWithPost(Post $post)
    {
        return $this->findOneBy(
                array(
                    'post' => $post,
                )
            );
    }
    
    /**
     * 
     * @param \Wozbe\BlogBundle\Entity\Post $post
     * @return \Wozbe\BlogBundle\Entity\PostGithub
     */
    public function getPostGithubWithOwnerRepoAndPath($owner, $repo, $path)
    {
        return $this->findOneBy(
                array(
                    'owner' => $owner,
                    'repo' => $repo,
                    'path' => $path,
                )
            );
    }
}
