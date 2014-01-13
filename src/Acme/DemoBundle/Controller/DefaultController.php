<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeDemoBundle:Default:index.html.twig', array(
            'rightNow' => new \DateTime('now')
        ));
    }

    public function loginAction(Request $request)
     {
         $session = $request->getSession();

         $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
         $session->remove(SecurityContext::AUTHENTICATION_ERROR);

         return $this->render(
             'AcmeDemoBundle:Default:login.html.twig',
             array(
                 // last username entered by the user
                 'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                 'error'         => $error,
             )
         );
     }
}
