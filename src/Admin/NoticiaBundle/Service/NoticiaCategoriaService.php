<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 02/06/2016
 * Time: 16:23
 */

namespace Admin\NoticiaBundle\Service;


use Admin\NoticiaBundle\Entity\NoticiaCategoria;
use Doctrine\ORM\EntityManagerInterface;

class NoticiaCategoriaService implements INoticiaCategoriaService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(NoticiaCategoria $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update(NoticiaCategoria $entity)
    {
        $this->em->flush();
    }

    public function delete(NoticiaCategoria $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}