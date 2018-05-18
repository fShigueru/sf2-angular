<?php

namespace Admin\ImageBundle\Service;

use Admin\StorageBundle\Service\IUploader;

class ImageService implements IImage
{
    private $upload;

    public function __construct(IUploader $upload)
    {
        $this->upload = $upload;
    }

    public function upload($entity,$path)
    {
        try{
            return $pathGal = $this->upload->upload($entity->getImage()->getFile(),$path);
        } catch(\Exception $e) {
            if(!empty($pathGal)){
                $this->upload->delete($pathGal);
            }
        }
    }

    public function remover($entity,$path)
    {
        $image = $path.'/'.$entity->getImage()->getImage();
        try{
            $this->upload->delete($image);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }


    public function multUpload($entity, $path)
    {
        foreach($entity->getImage() as $key => $value){
            if ($value->getFile() != null) {
                try{
                    $pathGal = $this->upload->upload($value->getFile(),$path.'/'.$entity->getId());
                    $value->setImage($pathGal);
                } catch(\Exception $e) {
                    if(!empty($pathGal)){
                        $this->upload->delete($pathGal);
                    }
                }
            }
        }
    }
}