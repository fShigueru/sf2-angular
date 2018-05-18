<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 14/08/2016
 * Time: 11:09
 */

namespace Admin\StorageBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Bundle\GaufretteBundle\FilesystemMap;

class Uploader implements IUploader
{
    private static $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif'
    );

    private $filesystem;

    public function __construct(FilesystemMap $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file, $path)
    {
        // Generate a unique filename based on the date and add file extension of the uploaded file
        $filename = sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), uniqid(), $file->getClientOriginalExtension());
        $filename = $path."/".$filename;

        $adapter = $this->filesystem->get("photo")->getAdapter();

        //$adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function delete($filename)
    {
        $adapter = $this->filesystem->get("photo")->getAdapter();
        return $adapter->delete($filename);
    }
}