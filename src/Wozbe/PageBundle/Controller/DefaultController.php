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
     * @Route("/", name="wozbe")
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function indexAction()
    {
        return $this->render('WozbePageBundle:Default:index.html.twig', array('name' => 'thomas'));
    }
}
