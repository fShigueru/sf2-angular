<?php

namespace Admin\GaleriaBundle\Service;

use Admin\GaleriaBundle\Entity\Galeria;
use Admin\GaleriaBundle\Entity\ImageGaleria;

interface IGaleriaService
{

    /**
     * Formata os dados e retorna um array
     *
     * @return mixed
     */
    public function formatOptions($entity);

    /**
     * @param $entity
     * @return mixed
     */
    public function insert(Galeria $entity);

    /**
     * @param Galeria $entity
     * @return mixed
     */
    public function update(Galeria $entity);

    /**
     * @param ImageGaleria $entity
     * @return mixed
     */
    public function updateImageGaleria(ImageGaleria $entity);


    /**
     * @param ImageGaleria $entity
     * @return mixed
     */
    public function deleteImage(ImageGaleria $entity);
}