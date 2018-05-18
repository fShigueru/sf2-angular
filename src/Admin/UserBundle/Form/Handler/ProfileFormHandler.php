<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\UserBundle\Form\Handler;

use Admin\ImageBundle\Service\ImageService;
use Admin\UserBundle\Form\ProfileFormType;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Form\Handler\ProfileFormHandler as BaseHandler;

class ProfileFormHandler extends BaseHandler
{
    protected $request;
    protected $userManager;
    protected $form;
    protected $imageService;
    protected $path = "user";

    public function __construct(FormFactory $form, Request $request, UserManagerInterface $userManager, ImageService $imageService)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
        $this->imageService = $imageService;
    }

    public function process(UserInterface $user)
    {
        if ('POST' === $this->request->getMethod()) {
            $formValid = $this->form->create(new ProfileFormType(), $user)->handleRequest($this->request);
            if ($formValid->isValid()) {
                if ($user->getImage()->getFile() != null) {
                    $user->getImage()->setImage($this->imageService->upload($user,$this->path));
                }
                $this->onSuccess($user);
                return true;
            }
            $this->userManager->reloadUser($user);
        }
        return false;
    }
}
