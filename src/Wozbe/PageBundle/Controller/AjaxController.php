<?php

namespace Wozbe\PageBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;

/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route("/contact", name="wozbe_ajax_contact")
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
                'title' => $translated = $this->get('translator')->trans('success'),
                'message' =>  $translated = $this->get('translator')->trans('message_sent_to', array('%email%' => $this->container->getParameter('email'))),
            ));
        }
        
        return new Response('Server accept only XML HTTP Request', 400);
    }
}
