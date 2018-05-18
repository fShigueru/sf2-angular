<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 10/02/2016
 * Time: 15:42
 */

namespace Admin\IMageBundle\Service;

interface IImage
{

    /**
     * Upload de imagem, S3 AWS
     * @param $entity
     * @param $path
     * @return mixed
     */
    public function upload($entity, $path);
    /**
     * Remove uma imagem especifica , S3 AWS
     * @param $entity
     * @param $path
     * @return mixed
     */
    public function remover($entity,$path);

    public function multUpload($entity, $path);

}