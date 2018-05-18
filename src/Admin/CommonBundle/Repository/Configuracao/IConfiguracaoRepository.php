<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/04/2016
 * Time: 17:31
 */

namespace Admin\CommonBundle\Repository\Configuracao;


interface IConfiguracaoRepository
{

    /**
     * busca a configura��o pela chave
     * @param $key
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\Config\Definition\Exception\Exception
     */
    public function porChave($key);

}