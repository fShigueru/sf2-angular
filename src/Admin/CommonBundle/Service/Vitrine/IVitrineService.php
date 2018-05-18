<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 25/04/2016
 * Time: 12:32
 */

namespace Admin\CommonBundle\Service\Vitrine;

use Admin\CommonBundle\Entity\Vitrine;

interface IVitrineService
{
    public function insert(Vitrine $entity);
    public function update(Vitrine $entity);
    public function delete(Vitrine $entity);
}