<?php

namespace Wozbe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\BlogBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/blog/github_hook_blog_content", options={"sitemap" = false})
     * @Method({"POST"})
     */
    public function githubHookBlogContentAction(Request $request)
    {
        $payloadResult = json_decode($request->request->get('payload'));
        
        $pathAddedList = $payloadResult['commits']['added'];
        $pathRemovedList = $payloadResult['commits']['removed'];
        $pathModifiedList = $payloadResult['commits']['modified'];
        
        $repo = $payloadResult['repository']['name'];
        $owner = $payloadResult['repository']['owner']['name'];
        
        $postGithubRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:PostGithub');
        $postGithubModifiedList = $postGithubRepository->getPostsGithubWithOwnerRepoAndPath($owner, $repo, $path);
        $postGithubRemovedList = $postGithubRepository->getPostsGithubWithOwnerRepoAndPath($owner, $repo, $path);
        
        foreach($postGithubModifiedList as $postGithubModified) {
            $this->getPostGithubManager()->updatePostFromGithub($postGithubModified);
        }
    }
    
    /**
     * @Route("/blog/github_hook_blog_content", options={"sitemap" = false})
     * @Method({"GET"})
     */
    public function githubHookBlogContentGetAction(Request $request)
    {
        $pathModifiedList = $request->query->get('modified');
        
        $repo = $request->query->get('repo');
        $owner = $request->query->get('owner');
        
        $postGithubRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:PostGithub');
        $postGithubModifiedList = $postGithubRepository->getPostsGithubWithOwnerRepoAndPaths($owner, $repo, $pathModifiedList);
        
        foreach($postGithubModifiedList as $postGithubModified) {
            $this->getPostGithubManager()->updatePostFromGithub($postGithubModified);
        }
    }
    
    /**
     * @Route("/{_locale}/blog", name="wozbe_blog", requirements={"_locale" = "fr"}, options={"sitemap" = true})
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     * @Template()
     */
    public function indexAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Post');
        
        return array(
            'posts' => $postRepository->findPublished()
        );
    }

    /**
     * @Route("/{_locale}/blog/{slug}", name="wozbe_blog_post", requirements={"_locale" = "fr"}, options={"sitemap" = true})
     * @ParamConverter("post", class="WozbeBlogBundle:Post")
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     * @Template()
     */
    public function postAction(Post $post)
    {
        $comments = $this->getDoctrine()->getRepository('WozbeBlogBundle:Comment')->findByPost($post);
        
        $post_content = str_replace('{{ site.url }}', 'http://localhost/Wozbe/bundles/wozbeblog/', $post->getContent());
        
        return array(
            'post' => $post,
            'post_content' => $post_content,
            'comments' => $comments,
        );
    }
    
    /**
     * 
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    protected function getCommentManager()
    {
        return $this->get('wozbe_blog.manager.comment');
    }
    
    /**
     * 
     * @return \Wozbe\BlogBundle\Entity\PostGithubManager
     */
    protected function getPostGithubManager()
    {
        return $this->get('wozbe_blog.manager.post_github');
    }
}
