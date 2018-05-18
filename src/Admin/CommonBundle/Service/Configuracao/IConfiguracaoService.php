<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/04/2016
 * Time: 17:37
 */

namespace Admin\CommonBundle\Service\Configuracao;

use Doctrine\ORM\EntityManagerInterface;

interface IConfiguracaoService
{

    public function __construct(EntityManagerInterface $em);

    /**
     * busca a configuração pela chave/key
     * @param $key
     * @return mixed
     */
    public function valor($key);

}