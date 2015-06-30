<?php

namespace Wozbe\PageBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="wozbe_root", options={"sitemap" = true})
     * @Method({"GET", "HEAD"})
     */
    public function rootAction()
    {
        return $this->redirect($this->generateUrl('wozbe'));
    }
    
    /**
     * @Route("/{_locale}", name="wozbe", options={"sitemap" = true})
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function indexAction()
    {
        return $this->render('WozbePageBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/{_locale}/skills", name="wozbe_skills", options={"sitemap" = true})
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function skillssAction()
    {
        return $this->render('WozbePageBundle:Default:skills.html.twig');
    }
    
    /**
     * @Route("/{_locale}/references", name="wozbe_references", options={"sitemap" = true})
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function referencesAction()
    {
        return $this->render('WozbePageBundle:Default:references.html.twig');
    }
}
