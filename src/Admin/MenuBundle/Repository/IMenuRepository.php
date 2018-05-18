<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 10/03/2016
 * Time: 17:02
 */

namespace Admin\MenuBundle\Repository;


interface IMenuRepository
{

    /**
     * Busca o Menu relacionado com uma Pagina no banco de dados
     *
     * @param $entity
     * @return mixed
     */
    public function findMenuPagina($entity);

    /**
     * Busca no banco de dado os Menus que estão com status igual a 1
     *
     * @return mixed
     */
    public function findAllMenuAtivo();

    /**
     * Busca no banco de dado os Menus que estão com status igual a 0
     *
     * @return mixed
     */
    public function findAllMenuInativo();

}