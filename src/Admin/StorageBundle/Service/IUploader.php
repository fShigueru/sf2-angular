<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 14/08/2016
 * Time: 11:02
 */

namespace Admin\StorageBundle\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IUploader
{
    public function upload(UploadedFile $file, $path);
    public function delete($filename);
}