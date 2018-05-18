<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/11/2015
 * Time: 13:12
 */

namespace Admin\EnderecoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class CidadeRepository extends EntityRepository
{

    /**
     *
     * Retorna a cidade por estado
     *
     * @param $entity
     * @return array
     */
    public function buscaPorEstado($entity)
    {
        return $this
            ->createQueryBuilder("c")
            ->select('c.id','c.nome')
            ->where("c.estado = :estado")
            ->setParameter(":estado",$entity->getSigla())
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     *
     * Retorna a cidade por estado e cidade
     *
     * @param $entity
     * @return array
     */
    public function buscaPorEstadoWithCidade($entity)
    {
        return $this
            ->createQueryBuilder("c")
            ->select('c.id','c.nome')
            ->where("c.estado = :estado")
            ->andWhere("c.nome = :nome")
            ->setParameter(":estado",$entity->getEstado()->getSigla())
            ->setParameter(":nome",$entity->getNome())
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getSingleResult()
            ;
    }
}