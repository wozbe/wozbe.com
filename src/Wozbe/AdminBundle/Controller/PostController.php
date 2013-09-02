<?php

namespace Wozbe\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\AdminBundle\Form\Type\PostType;

use Wozbe\BlogBundle\Entity\Post;

/**
 * @Route("/admin/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function listAction()
    {
        $posts = $this->getPostRepository()->findAll();
        
        return array('posts' => $posts);
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction()
    {
        return $this->handleForm(new Post());
    }

    /**
     * @Route("/edit/{slug}")
     * @ParamConverter("post", class="WozbeBlogBundle:Post")
     * @Template()
     */
    public function editAction(Post $post)
    {
        return $this->handleForm($post);
    }
    
    /**
     * @Route("/remove/{slug}")
     * @ParamConverter("post", class="WozbeBlogBundle:Post")
     */
    public function removeAction(Post $post)
    {
        $this->getPostManager()->delete($post);
        
        $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('Post deleted: %s', $post->getSlug()));
        
        return $this->redirect($this->generateUrl('wozbe_admin_post_list'));
    }
    
    protected function handleForm(Post $post)
    {
        $form = $this->createForm(new PostType(), $post);

        $request = $this->getRequest();
        
        if ('POST' === $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getPostManager()->add($post);
                
                $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('Post update: %s', $post->getSlug()));
                
                $postUrl = $this->generateUrl('wozbe_admin_post_list');
                
                return $this->redirect($postUrl);
            } else {
                $this->getRequest()->getSession()->getFlashBag()->add('admin', 'A problem occured');
            }
        }
        
        return array(
            'post' => $post,
            'form' => $form->createView()
        );
    }

    /**
     * @return \Wozbe\BlogBundle\Entity\PostRepository
     */
    protected function getPostRepository() 
    {
        return $this->get('wozbe_blog.repository.post');
    }

    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostManager
     */
    protected function getPostManager() 
    {
        return $this->get('wozbe_blog.manager.post');
    }
}
