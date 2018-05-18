<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 18/04/2016
 * Time: 13:41
 */

namespace Admin\PaginaBundle\Repository;


/**
 * Interface IPaginaRepository
 * @package Admin\PaginaBundle\Repository
 */
interface IPaginaRepository
{

    /**
     * Retorna as páginas com o status = 1, que são as páginas ativas
     * em ordem decrescente
     *
     * @return mixed
     */
    public function findAllActive();

}