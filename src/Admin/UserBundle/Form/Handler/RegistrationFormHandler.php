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

use Admin\ImageBundle\Entity\Image;
use Admin\ImageBundle\Entity\ImageProporcao;
use Admin\ImageBundle\Service\ImageService;
use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;


class RegistrationFormHandler extends BaseHandler
{
    protected $request;
    protected $userManager;
    protected $form;
    protected $mailer;
    protected $tokenGenerator;
    protected $imageService;
    protected $path = "user";

    public function __construct(FormInterface $form, Request $request, UserManagerInterface $userManager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, ImageService $imageService)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->imageService = $imageService;
    }

    public function process($confirmation = false)
    {
        $user = $this->createUser();
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setCropSizeW("214");
        $fotoProporcoes->setCropSizeH("214");
        $fotoProporcoes->setThumbW("56");
        $fotoProporcoes->setThumbH("56");
        $foto->addProporcoes($fotoProporcoes);
        $user->setImage($foto);
        $this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {

                if ($user->getImage()->getFile() != null) {
                    $user->getImage()->setImage($this->imageService->upload($user,$this->path));
                }

                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }
}
