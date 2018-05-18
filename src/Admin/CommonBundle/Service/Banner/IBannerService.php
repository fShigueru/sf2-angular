<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 25/04/2016
 * Time: 12:31
 */

namespace Admin\CommonBundle\Service\Banner;

use Admin\CommonBundle\Entity\Banner;

interface IBannerService
{
    public function insert(Banner $entity);
    public function update(Banner $entity);
    public function delete(Banner $entity);
}