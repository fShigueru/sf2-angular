<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 25/04/2016
 * Time: 12:39
 */

namespace Admin\CommonBundle\Service\Vitrine;


use Admin\CommonBundle\Entity\Vitrine;
use Doctrine\ORM\EntityManagerInterface;

class VitrineService implements IVitrineService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(Vitrine $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update(Vitrine $entity)
    {
        $this->em->flush();
    }

    public function delete(Vitrine $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}