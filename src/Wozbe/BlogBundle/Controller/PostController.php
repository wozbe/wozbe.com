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
        //https://api.github.com/repos/wozbe/BlogContent/contents/posts/2013-08-09-deploiement-application-symfony-avec-capifony.md
        //GET /repos/:owner/:repo/contents/:path
        
        $payloadResult = json_decode($request->request->get('payload'));
        
        $path = $payloadResult['commits']['added'];
        $path = $payloadResult['commits']['removed'];
        $path = $payloadResult['commits']['modified'];
        
        $repo = $payloadResult['repository']['name'];
        $owner = $payloadResult['repository']['owner']['name'];
        
        $postGithubRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:PostGithub');
        $postGithub = $postGithubRepository->getPostGithubWithOwnerRepoAndPath($owner, $repo, $path);
        
        if(!$postGithub) {
            throw $this->createNotFoundException();
        }
        
        $this->getPostGithubMasager()->updatePostFromGithub($postGithub);
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
