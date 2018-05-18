<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 07/05/2016
 * Time: 16:55
 */

namespace Admin\UserBundle\Service;

/**
 * Interface IAutorizacaoService
 * @package Admin\UserBundle\Service
 */
interface IAutorizacaoService
{

    /**
     * @return mixed
     */
    public function verificarAutorizacao(array $roles);
}