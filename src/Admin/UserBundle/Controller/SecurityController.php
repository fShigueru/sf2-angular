<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/05/2015
 * Time: 19:29
 */

namespace Admin\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use \Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends BaseController
{
    public function loginAction()
    {

        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $route = $this->container->get('router');
            $redirect = new RedirectResponse($route->generate('dashboard'));
            return $redirect;
        }

        return parent::loginAction();
    }
}