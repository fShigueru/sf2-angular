<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 07/05/2016
 * Time: 16:55
 */

namespace Admin\UserBundle\Service;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker ;

class AutorizacaoService implements IAutorizacaoService
{
    protected $auth;

    /**
     * AutorizacaoService constructor.
     */
    public function __construct(AuthorizationChecker $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function verificarAutorizacao(array $roles = null)
    {
        $roles[] = 'ROLE_ADMIN';

        if(!$this->auth->isGranted($roles))
            return false;

        return true;
    }
}