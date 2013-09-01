<?php

namespace Wozbe\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use JMS\SecurityExtraBundle\Annotation\Secure;

class DashboardController extends Controller
{
    /**
     * @Route("/admin", name="wozbe_admin_dashboard")
     * @Template()
     * @Method({"GET", "HEAD"})
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        return array();
    }
}
