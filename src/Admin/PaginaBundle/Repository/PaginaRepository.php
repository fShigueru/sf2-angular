<?php

namespace Admin\PaginaBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PaginaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaginaRepository extends EntityRepository implements IPaginaRepository
{

    public function findAllActive()
    {
        return $this
            ->createQueryBuilder("p")
            ->where("p.status = :status")
            ->setParameter("status", 1)
            ->addOrderBy('p.created', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}