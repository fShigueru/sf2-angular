<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 02/06/2016
 * Time: 16:23
 */

namespace Admin\NoticiaBundle\Service;


use Admin\NoticiaBundle\Entity\NoticiaCategoria;

interface INoticiaCategoriaService
{
    public function insert(NoticiaCategoria $entity);
    public function update(NoticiaCategoria $entity);
    public function delete(NoticiaCategoria $entity);
}