<?php

namespace Wozbe\PageBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;

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
        return $this->render('WozbePageBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/skills", name="wozbe_skills")
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function skillssAction()
    {
        return $this->render('WozbePageBundle:Default:skills.html.twig');
    }
    
    /**
     * @Route("/references", name="wozbe_references")
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function referencesAction()
    {
        return $this->render('WozbePageBundle:Default:references.html.twig');
    }
    
    /**
     * @Route("/contact", name="wozbe_contact")
     * @Method({"GET", "HEAD"})
     * @Cache(expires="+2 hours", public="true")
     */
    public function contactAction()
    {
        return $this->render('WozbePageBundle:Default:contact.html.twig');
    }
    
    /**
     * @Route("/ajax/contact", name="wozbe_ajax_contact")
     * @Method({"POST"})
     */
    public function contactAjaxAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $email = $request->request->get('email');
            $message = $request->request->get('message');
            
            $emailConstraint = new Email();
            
            $errorList = $this->get('validator')->validateValue(
                $email,
                $emailConstraint
            );
            
            if (count($errorList) > 0) {
                // this is *not* a valid email address
                return new Response($errorList[0]->getMessage(), 400);
            }
            
            $swiftMail = \Swift_Message::newInstance()
                ->setSubject('Contact Wozbe')
                ->setFrom($email)
                ->setTo($this->container->getParameter('email'))
                ->setBody($message)
            ;
            $this->get('mailer')->send($swiftMail);
            
            return new JsonResponse(array (
                'title' => 'Success !',
                'message' =>  'Your message was sent to ' . $this->container->getParameter('email'),
            ));
        }
        
        return new Response('Server accept only XML HTTP Request', 400);
    }
}
