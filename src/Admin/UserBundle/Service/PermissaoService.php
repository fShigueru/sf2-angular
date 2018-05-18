<?php

namespace Admin\UserBundle\Service;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class PermissaoService
{

    private $auth;
    private $translator;
    /**
     * PermissaoService constructor.
     */
    public function __construct(AuthorizationCheckerInterface $auth, Translator $translator)
    {
        $this->auth = $auth;
        $this->translator = $translator;
    }


    public function apenasSuperAdmin(){
        if(!$this->auth->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException($this->translator->transChoice('title.permissao.negada',0,array(),'messagesCommonBundle'));
        }
        return true;
    }

}