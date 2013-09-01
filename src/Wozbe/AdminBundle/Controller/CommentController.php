<?php

namespace Wozbe\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\AdminBundle\Form\Type\CommentType;

use Wozbe\BlogBundle\Entity\Comment;

/**
 * @Route("/admin/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function listAction()
    {
        $comments = $this->getCommentRepository()->findAll();
        
        return array('comments' => $comments);
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction()
    {
        return $this->handleForm(new Comment());
    }

    /**
     * @Route("/edit/{id}")
     * @ParamConverter("comment", class="WozbeBlogBundle:Comment")
     * @Template()
     */
    public function editAction(Comment $comment)
    {
        return $this->handleForm($comment);
    }
    
    /**
     * @Route("/remove/{id}")
     * @ParamConverter("comment", class="WozbeBlogBundle:Comment")
     */
    public function removeAction(Comment $comment)
    {
        $this->getCommentManager()->deleteComment($comment);
        
        $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('Comment deleted'));
        
        return $this->redirect($this->generateUrl('wozbe_admin_comment_list'));
    }
    
    protected function handleForm(Comment $comment)
    {
        $form = $this->createForm(new CommentType(), $comment);

        $request = $this->getRequest();
        
        if ('POST' === $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getCommentManager()->saveComment($comment);
                
                $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('Comment update: %d', $comment->getId()));
                
                $commentUrl = $this->generateUrl('wozbe_admin_comment_list');
                
                return $this->redirect($commentUrl);
            } else {
                $this->getRequest()->getSession()->getFlashBag()->add('admin', 'A problem occured');
            }
        }
        
        return array(
            'comment' => $comment,
            'form' => $form->createView()
        );
    }

    /**
     * @return \Wozbe\BlogBundle\Entity\CommentRepository
     */
    protected function getCommentRepository() 
    {
        return $this->get('wozbe_blog.repository.comment');
    }

    
    /**
     * @return \Wozbe\BlogBundle\Entity\CommentManager
     */
    protected function getCommentManager() 
    {
        return $this->get('wozbe_blog.manager.comment');
    }
}
