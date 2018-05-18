<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/05/2015
 * Time: 19:17
 */

namespace Admin\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController {

    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $translated = $this->container->get('translator');
        $session = $this->container->get('session');

        $process = $formHandler->process($confirmationEnabled);

        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
                //$session->getFlashBag()->add('error', $translated->transChoice('title.usuario.update.error',0,array(),'FOSUserBundle'));
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
                $session->getFlashBag()->add('sucesso', $translated->transChoice('registration.flash.user_created',0,array(),'FOSUserBundle'));
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');

            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request)
    {
        $token = $request->query->get('token');
        $response = parent::confirmAction($token);
        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $response = parent::confirmedAction();
        return $response;
    }
}