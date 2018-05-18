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

use Admin\UserBundle\Entity\User;
use Admin\UserBundle\Form\ProfileFormType;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Presta\SitemapBundle\Exception\Exception;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
        return parent::showAction();
    }

    /**
     * Edit the user
     */
    public function editAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //$form = $this->container->get('fos_user.profile.form');
        $formNew = $this->container->get('form.factory');
        $form = $formNew->create(new ProfileFormType(), $user)->createView();

        $formHandler = $this->container->get('fos_user.profile.form.handler');
        $process = $formHandler->process($user);
        $translated = $this->container->get('translator');
        $session = $this->container->get('session');
        $request = Request::createFromGlobals();

        if($request->getMethod() == "POST"){
            if ($process) {
                try{
                    $session->getFlashBag()->add('sucesso', $translated->transChoice('profile.flash.updated',0,array(),'FOSUserBundle'));
                    return new RedirectResponse($this->getRedirectionUrl($user));
                }catch(Exception $e){
                    $session->getFlashBag()->add('error', $translated->transChoice('title.usuario.update.error',0,array(),'messagesUserBundle'));
                }
            }else{
                $session->getFlashBag()->add('error', $translated->transChoice('title.usuario.update.error',0,array(),'messagesUserBundle'));
            }
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form, 'entity' => $user)
        );
    }

}
