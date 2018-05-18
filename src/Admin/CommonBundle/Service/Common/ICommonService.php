<?php

namespace Admin\CommonBundle\Service\Common;


/**
 *
 * Essa interface carrega serviços comum entre toda a aplicação
 *
 * Interface ICommonService
 * @package Admin\CommonBundle\Service\Configuracao
 */
interface ICommonService
{


    /**
     * * Essa função é responsavel por verificar se existe um slug cadastrado para um entidade
     * @param $entity
     * @param $repositoryName
     * @return mixed
     */
    public function verificarSlug($entity, $repositoryName);

}