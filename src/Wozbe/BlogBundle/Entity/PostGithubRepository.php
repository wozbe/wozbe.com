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
     * @param string $owner
     * @param string $repo
     * @param array $paths
     * @return \Wozbe\BlogBundle\Entity\PostGithub[]
     */
    public function getPostsGithubWithOwnerRepoAndPaths($owner, $repo, array $paths)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('post_github')
            ->from('\Wozbe\BlogBundle\Entity\PostGithub', 'post_github')
            ->where('post_github.owner = :owner')
            ->andWhere('post_github.repo = :repo')
            ->andWhere($qb->expr()->in('post_github.path', ':paths'))
            ->setParameter('owner', $owner)
            ->setParameter('repo', $repo)
            ->setParameter('paths', $paths)
            ;
        
        return $qb->getQuery()->getResult();
    }
}
