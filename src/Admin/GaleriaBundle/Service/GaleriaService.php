<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 11/05/2016
 * Time: 21:02
 */

namespace Admin\GaleriaBundle\Service;

use Admin\GaleriaBundle\Entity\Galeria;
use Admin\GaleriaBundle\Entity\ImageGaleria;
use Admin\StorageBundle\Service\PhotoUploader;
use Doctrine\ORM\EntityManagerInterface;

class GaleriaService implements IGaleriaService
{
    private $em;
    private $upload;

    /**
     * GaleriaService constructor.
     */
    public function __construct(EntityManagerInterface $em, PhotoUploader $upload)
    {
        $this->em = $em;
        $this->upload = $upload;
    }

    /**
     * Formata os dados e retorna um array
     *
     * @return mixed
     */
    public function formatOptions($entity)
    {
        $opcoesSemRegistro = ['Home','Contato'];
        $array = [];
        if(!in_array($entity, $opcoesSemRegistro)){
            $entities = $this->em->getRepository($entity)->findAll();
            if($entity == 'AdminPaginaBundle:Pagina'){
                foreach($entities as $key => $value){
                    foreach($value->getPaginaTextos() as $texto){
                        $array[$value->getId()] = $texto->getTitulo();
                    }
                }
            }
        }

        return $array;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function insert(Galeria $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update(Galeria $entity)
    {
        $this->em->flush();
    }

    /**
     * @param ImageGaleria $entity
     * @return mixed
     */
    public function updateImageGaleria(ImageGaleria $entity)
    {
        $this->em->flush();
    }

    /**
     * @param ImageGaleria $entity
     * @return mixed
     */
    public function deleteImage(ImageGaleria $entity)
    {
        $retorno = ['status'=>true];
        try{
            $this->upload->delete($entity->getImage());
        }catch (\Exception $e){
            $retorno['status'] = false;
            $retorno['message'] = $e->getMessage();
            return $retorno;
        }

        try{
            $this->em->remove($entity);
            $this->em->flush();
            return $retorno;
        }catch (\Exception $e){
            $retorno['status'] = false;
            $retorno['message'] = $e->getMessage();
            return $retorno;
        }

    }
}