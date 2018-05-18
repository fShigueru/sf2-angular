<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 25/04/2016
 * Time: 12:33
 */

namespace Admin\CommonBundle\Service\Banner;


use Admin\CommonBundle\Entity\Banner;
use Doctrine\ORM\EntityManagerInterface;

class BannerService implements IBannerService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(Banner $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update(Banner $entity)
    {
        $this->em->flush();
    }

    public function delete(Banner $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}