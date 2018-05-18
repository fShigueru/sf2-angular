<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 08/03/2016
 * Time: 20:27
 */

namespace Admin\MenuBundle\Service;


interface IMenu
{
    /**
     * Remove um menu do banco de dados
     * @param $id
     * @return mixed
     */
    public function removeMenu($id);

    /**
     * Adiciona um novo Menu
     * @param $entity
     * @return mixed
     */
    public function addMenuUrl($entity);

    /**
     * Retorna a lista pronta dos menus ativos do site
     * @return mixed
     */
    public function getMenusAtivo();

    /**
     * Retorna a lista pronta dos menus inativos do site
     * @return mixed
     */
    public function getMenusInativo();

    /**
     * Atualiza a lista de menus, tanto os ativos quanto os inativo
     * @param $post
     * @return mixed
     */
    public function updateMenuLista($post);

}