<?php

namespace Wozbe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\BlogBundle\Entity\Post;
use Wozbe\BlogBundle\Form\Type\CommentType;

class CommentController extends Controller
{
    /**
     * @Route("/{_locale}/blog/{slug}/comment", name="wozbe_blog_post_comment", requirements={"_locale" = "fr"})
     * @ParamConverter("post", class="WozbeBlogBundle:Post")
     * @Template()
     * @Method({"POST"})
     */
    public function addAction(Post $post)
    {
        $comment = $this->getCommentManager()->buildComment($post);
        
        $form = $this->createForm(new CommentType(), $comment, array(
            'action' => $this->generateUrl('wozbe_blog_post_comment', array('slug' => $comment->getPost()->getSlug())),
        ));

        $request = $this->getRequest();
        
        if ('POST' === $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getCommentManager()->saveComment($comment);
                
                $request->getSession()->getFlashBag()->add('comments', 'Your comment will be publish as soon as possible. Waiting for approbation.');
                
                $postUrl = $this->generateUrl('wozbe_blog_post', array('slug' => $post->getSlug()));
                
                return $this->redirect($postUrl . "#comments");
            } else {
                $request->getSession()->getFlashBag()->add('comments', 'Please check filled information');
            }
        }
        
        return array('form' => $form->createView());
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
