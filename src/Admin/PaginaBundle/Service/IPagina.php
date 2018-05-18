<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 10/02/2016
 * Time: 15:42
 */

namespace Admin\PaginaBundle\Service;


use Admin\MenuBundle\Entity\Menu;
use Admin\PaginaBundle\Entity\Pagina;

interface IPagina
{
    public function insert(Pagina $entity);
    public function update(Pagina $entity);
    public function delete(Pagina $entity);

    /**
     * Verifica se o slug existe, se não retorna true e o slug pronto
     * @param Pagina $entity
     * @return mixed
     */
    public function slug($entity);

    /**
     * Upload de imagem, S3 AWS
     * @param Pagina $entity
     * @return mixed
     */
    public function upload($entity);
    /**
     * Remove uma imagem especifica , S3 AWS
     * @param Pagina $entity
     * @return mixed
     */
    public function removerFoto($entity);


    /**
     * Inclui essa nova página no menu, mas vai desabilitado
     * @param $entity
     * @return mixed
     */
    public function addMenu($entity);

}