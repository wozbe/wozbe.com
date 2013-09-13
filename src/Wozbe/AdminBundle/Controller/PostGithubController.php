<?php

namespace Wozbe\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Wozbe\AdminBundle\Form\Type\PostGithubType;
use Wozbe\BlogBundle\Entity\PostGithub;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/admin/post_github")
 */
class PostGithubController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function listAction()
    {
        $postGithubList = $this->getPostGithubRepository()->findAll();
        
        return array('post_github_list' => $postGithubList);
    }

    /**
     * @Route("/create")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        return $this->handleForm(new PostGithub());
    }

    /**
     * @Route("/edit/{id}")
     * @ParamConverter("post_github", class="WozbeBlogBundle:PostGithub")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction(PostGithub $postGithub)
    {
        return $this->handleForm($postGithub);
    }
    
    /**
     * @Route("/remove/{id}")
     * @ParamConverter("post_github", class="WozbeBlogBundle:PostGithub")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(PostGithub $postGithub)
    {
        $this->getPostGithubManager()->delete($postGithub);
        
        $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('PostGithub deleted: %s', $postGithub->getId()));
        
        return $this->redirect($this->generateUrl('wozbe_admin_postgithub_list'));
    }
    
    /**
     * @Route("/open/{id}")
     * @ParamConverter("post_github", class="WozbeBlogBundle:PostGithub")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function openAction(PostGithub $postGithub)
    {
        return $this->handleForm($postGithub);
    }
    
    /**
     * @Route("/update/{id}")
     * @ParamConverter("post_github", class="WozbeBlogBundle:PostGithub")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(PostGithub $postGithub)
    {
        $this->getPostGithubManager()->updatePostFromGithub($postGithub);
        
        $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('PostGithub update: %s', $postGithub->getId()));
                
        $postGithubUrl = $this->generateUrl('wozbe_admin_postgithub_list');

        return $this->redirect($postGithubUrl);
    }
    
    protected function handleForm(PostGithub $postGithub)
    {
        $form = $this->createForm(new PostGithubType(), $postGithub);

        $request = $this->getRequest();
        
        if ('POST' === $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getPostGithubManager()->add($postGithub);
                
                $this->getRequest()->getSession()->getFlashBag()->add('admin', sprintf('PostGithub update: %s', $postGithub->getId()));
                
                $postGithubUrl = $this->generateUrl('wozbe_admin_postgithub_list');
                
                return $this->redirect($postGithubUrl);
            } else {
                $this->getRequest()->getSession()->getFlashBag()->add('admin', 'A problem occured');
            }
        }
        
        return array(
            'post_github' => $postGithub,
            'form' => $form->createView()
        );
    }

    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubRepository
     */
    protected function getPostGithubRepository() 
    {
        return $this->get('wozbe_blog.repository.post_github');
    }

    
    /**
     * @return \Wozbe\BlogBundle\Entity\PostGithubManager
     */
    protected function getPostGithubManager() 
    {
        return $this->get('wozbe_blog.manager.post_github');
    }
}
