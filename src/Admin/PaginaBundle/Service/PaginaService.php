<?php

namespace Admin\PaginaBundle\Service;
use Admin\MenuBundle\Entity\Menu;
use Admin\PaginaBundle\Entity\Pagina;
use Admin\StorageBundle\Service\PhotoUploader;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Translator;

class PaginaService implements IPagina
{

    private $path = 'pagina';
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

    public function insert(Pagina $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update(Pagina $entity)
    {
        $this->em->flush();
    }

    public function delete(Pagina $entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     *  Verifica se o slug existe
     *
     * @param $entity
     * @return bool|string
     */
    public function slug($entity)
    {
        $slug = $this->slugify->slugify($entity->getSlug());
        $pagina = $this->em->getRepository('AdminPaginaBundle:PaginaTexto')->findOneBySlug($slug);

        $retorno = [];

        //se existir um slug cadastrado
        if($pagina != null){
            $retorno['entity'] = $pagina;
            $retorno['status'] = false;
        }
        //se não existir um slug cadastrado
        else{
            $entity->setSlug($slug);
            $retorno['status'] = true;
            $retorno['entity'] = $entity;
        }
        return $retorno;
    }

    public function upload($entity)
    {
        try{
            return $pathGal = $this->upload->upload($entity->getFoto()->getFile(), $this->path);

        } catch(\Exception $e) {
            if(!empty($pathGal)){
                $this->upload->delete($pathGal);
            }
        }
    }

    public function removerFoto($entity)
    {
        $image = $this->path.'/'.$entity->getFoto()->getFile();
        try{
            $this->upload->delete($image);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    public function addMenu($entity)
    {
        $menu = new Menu();
        $menu->setRoute('app_pagina');
        $menu->setClasse('AdminPaginaBundle:Pagina');
        $menu->setClasseId($entity->getId());
        $menu->setStatus(0);

        try{
            $this->em->persist($menu);
            $this->em->flush();
            return true;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

}