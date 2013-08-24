<?php

namespace Wozbe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\BlogBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/blog", name="wozbe_blog", requirements={"_locale" = "fr"}, options={"sitemap" = true})
     * @Template()
     */
    public function indexAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('WozbeBlogBundle:Post');
        
        return array(
            'posts' => $postRepository->findAll()
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
            'post_content' => $post->getContent(),
            'comments' => $comments,
        );
    }
    
    /**
     * @Route("/{_locale}/blog/{slug}/comment", name="wozbe_blog_post_comment", requirements={"_locale" = "fr"})
     * @ParamConverter("post", class="WozbeBlogBundle:Post")
     * @Method({"POST"})
     */
    public function commentAction(Post $post)
    {
        // TODO - Use Symfony Form
        $request = $this->getRequest();
        
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $website = $request->request->get('website');
        $content = $request->request->get('content');

        $comment = $this->getDoctrine()->getRepository('WozbeBlogBundle:Comment')->addComment($post, $username, $email, $website, $content);

        return $this->redirect($this->generateUrl('wozbe_blog_post', array('slug' => $post->getSlug())) . "#comment-" . $comment->getId());
    }
}
