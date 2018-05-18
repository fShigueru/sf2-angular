<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 09/06/2016
 * Time: 17:43
 */

namespace Admin\CommonBundle\Service\Common;

use Admin\StorageBundle\Service\PhotoUploader;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Translator;

class CommonService implements ICommonService
{

    private $em;
    private $translator;
    private $slugify;
    private $upload;

    public function __construct(EntityManagerInterface $em, Translator $translator, Slugify $slugify, PhotoUploader $upload)
    {
        $this->em = $em;
        $this->translator = $translator;
        $this->slugify = $slugify;
        $this->upload = $upload;
    }

    public function verificarSlug($entity, $repositoryName)
    {
        $slug = $this->slugify->slugify($entity->getSlug());
        $reEntity = $this->em->getRepository($repositoryName)->findOneBySlug($slug);
        $retorno = [];

        //se existir um slug cadastrado
        if($reEntity != null){
            $retorno['entity'] = $reEntity;
            $retorno['status'] = false;
            $retorno['message'] =  $this->translator->transChoice('title.slug.existe',0,array(),'messagesCommonBundle');
        }
        //se não existir um slug cadastrado
        else{
            $entity->setSlug($slug);
            $retorno['entity'] = $entity;
            $retorno['status'] = true;
        }
        return $retorno;
    }
}