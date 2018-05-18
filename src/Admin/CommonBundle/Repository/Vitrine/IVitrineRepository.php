<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/04/2016
 * Time: 17:20
 */

namespace Admin\CommonBundle\Repository\Vitrine;


/**
 * Interface IVitrineRepository
 * @package Admin\CommonBundle\Repository\Vitrine
 */
interface IVitrineRepository
{

    /**
     * Busca todas as vitrines pelo campo order e data de criacao
     * @return mixed
     */
    public function findAllByOrder();


    /**
     * Busca as vitrines por filtros
     * Para ser exibido
     * Se a data de hoje for maior e igual a data de publica��o ou se a data de publica��o for null
     * Se a data de hoje for menor e igual a data de expira��o ou se a data de expira��o for null
     *
     * @return mixed
     */
    public function findAllByFilter();

}