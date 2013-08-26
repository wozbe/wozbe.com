<?php

namespace Wozbe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\BlogBundle\Entity\Post;

class PostController extends Controller
{
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
}
