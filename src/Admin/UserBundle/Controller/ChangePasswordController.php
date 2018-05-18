<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\UserBundle\Controller;

use FOS\UserBundle\Controller\ChangePasswordController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class ChangePasswordController extends BaseController
{
    /**
     * Change user password
     */
    public function changePasswordAction()
    {

        $request = Request::createFromGlobals();

        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.change_password.form');
        $formHandler = $this->container->get('fos_user.change_password.form.handler');
        $translated = $this->container->get('translator');
        $session = $this->container->get('session');


        if($request->isMethod("POST")){
            $process = $formHandler->process($user);
            if ($process) {
                try{
                    $session->getFlashBag()->add('sucesso', $translated->transChoice('change_password.flash.success',0,array(),'FOSUserBundle'));
                    return new RedirectResponse($this->getRedirectionUrl($user));
                }catch(\Exception $e){
                    $session->getFlashBag()->add('error', $translated->transChoice('title.usuario.update.error',0,array(),'messagesUserBundle'));
                }
            }
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }

}
