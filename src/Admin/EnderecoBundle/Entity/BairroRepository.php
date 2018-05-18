<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 23/08/2015
 * Time: 15:06
 */

namespace Admin\EnderecoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BairroRepository extends EntityRepository
{

    /**
     *
     * Verifica se o bairro não é duplicado, apartir do nome do bairro e da cidade
     *
     * @param $entity
     * @return array
     */
    public function validarSeBairroDuplicado($entity)
    {
        return $this
            ->createQueryBuilder("b")
            ->where("b.nome = :nome")
            ->andWhere("b.cidade = :cidade")
            ->setParameter(":nome",$entity->getNome())
            ->setParameter(":cidade",$entity->getCidade())
            ->getQuery()
            ->getResult()
         ;

    }

    public function buscarBairrosPorCidadeLazy($cidade)
    {
        return $this
            ->createQueryBuilder("b")
            ->select('b.id','b.nome')
            ->where("b.cidade = :cidade")
            ->setParameter(":cidade",$cidade->getId())
            ->orderBy('b.nome', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}