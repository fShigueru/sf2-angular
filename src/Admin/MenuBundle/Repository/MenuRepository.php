<?php

namespace Admin\MenuBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends EntityRepository implements IMenuRepository
{

    public function findMenuPagina($entity)
    {
        return $this
            ->createQueryBuilder("m")
            ->where("m.classe = :classe")
            ->andWhere("m.classe_id = :classe_id")
            ->setParameter(":classe","AdminPaginaBundle:Pagina")
            ->setParameter(":classe_id",$entity->getId())
            ->getQuery()
            ->getSingleResult()
            ;
    }

    public function findAllMenuAtivo()
    {
        return $this
            ->createQueryBuilder("m")
            ->where("m.status = :status")
            ->setParameter(":status",1)
            ->addOrderBy('m.posicao', 'ASC')
            ->getQuery()
            ->getResult()
            ;

    }

    public function findAllMenuInativo()
    {
        return $this
            ->createQueryBuilder("m")
            ->where("m.status = :status")
            ->setParameter(":status",0)
            ->getQuery()
            ->getResult()
            ;

    }
}