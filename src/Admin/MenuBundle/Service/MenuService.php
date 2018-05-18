<?php

namespace Admin\MenuBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Translation\Translator;

class MenuService implements IMenu
{
    private $em;
    private $translator;
    private $form;

    public function __construct(EntityManagerInterface $em, Translator $translator, FormFactory $form)
    {
        $this->em = $em;
        $this->translator = $translator;
        $this->form = $form;
    }

    public function removeMenu($id)
    {
        $retorno = [];
        $retorno['status'] = true;

        $entity = $this->em->getRepository('AdminMenuBundle:Menu')->find($id);

        if(!$entity){
            $retorno['status'] = false;
            $retorno['message'] = "Algo estranho aconteceu, esse menu não existe, por favor atualize a página e tente novamente.";
            return $retorno;
        }

        /**
         * atualiza para inativos
         */
        if(!empty($entity->getMenuFilho())){
            foreach($entity->getMenuFilho() as $children){
                $children->setPosicao(0);
                $children->setStatus(0);
                $children->setMenuPai(null);
            }
        }

        try{
            $this->em->remove($entity);
            $this->em->flush();
            $retorno['message'] = "Menu removido com sucesso.. Aguarde alguns instantes, a página será atualizada.";
        }catch (\Exception $e){
            $retorno['status'] = false;
            $retorno['message'] = "Erro ao atualizar o menu. " . $e->getMessage();
        }

        return $retorno;
    }

    public function addMenuUrl($entity)
    {
        $retorno = [];
        $retorno['status'] = true;

        try{
            $this->em->persist($entity);
            $this->em->flush();
            $retorno['message'] = "Menu inserido com sucesso";
        }catch (\Exception $e){
            $retorno['status'] = false;
            $retorno['message'] = "Erro ao inserir um menu. " . $e->getMessage();
        }

        return $retorno;
    }

    public function getMenusAtivo()
    {
        $entities = $this->em->getRepository('AdminMenuBundle:Menu')->findAllMenuAtivo();

        foreach($entities as $key => $entity){
            if ($entity->getMenuPai() != null) {
                unset($entities[$key]);
            }
        }

        foreach($entities as $entity){

            if(!empty($entity->getClasse())){
                $entity->setEntity($this->em->getRepository($entity->getClasse())->find($entity->getClasseId()));
            }
            foreach($entity->getMenuFilho() as $menuFilho){
                if(!empty($menuFilho->getClasse())){
                    $menuFilho->setEntity($this->em->getRepository($menuFilho->getClasse())->find($menuFilho->getClasseId()));
                }
            }
        }

        return $entities;
    }

    public function getMenusInativo()
    {
        $entities = $this->em->getRepository('AdminMenuBundle:Menu')->findAllMenuInativo();
        foreach($entities as $entity){
            if(!empty($entity->getClasse())){
                $entity->setEntity($this->em->getRepository($entity->getClasse())->find($entity->getClasseId()));
            }
        }
        return $entities;
    }

    public function updateMenuLista($post)
    {
        $retorno = [];
        $retorno['status'] = true;
        $ativo = $post[0];
        $inativo = $post[1];
        /*
         * Monta o menu ativo com o status 1
         */
        foreach($ativo as $key =>  $value){
            $entity = $this->em->getRepository('AdminMenuBundle:Menu')->find($value->id);
            $entity->setPosicao(($key+1));
            $entity->setStatus(1);

            if(!empty($value->children[0])){
                foreach($value->children[0] as $keyChildren => $valueChildren){
                    $children = $this->em->getRepository('AdminMenuBundle:Menu')->find($valueChildren->id);
                    $children->setPosicao(($keyChildren+1));
                    $children->setStatus(1);
                    $entity->addMenuFilho($children);
                    $children->setMenuPai($entity);
                }
            }
        }

        /*
         * Monta o menu inativo com o status 0
         */
        foreach($inativo as $key =>  $value){
            $entity = $this->em->getRepository('AdminMenuBundle:Menu')->find($value->id);
            $entity->setPosicao(0);
            $entity->setStatus(0);
            $entity->setMenuPai(null);
            if(!empty($value->children[0])){
                foreach($value->children[0] as $keyChildren => $valueChildren){
                    $children = $this->em->getRepository('AdminMenuBundle:Menu')->find($valueChildren->id);
                    $children->setPosicao(0);
                    $children->setStatus(0);
                    $children->setMenuPai(null);
                }
            }
        }

        try{
            $this->em->flush();
            $retorno['message'] = "Lista de menus atualizada com sucesso";
        }catch(\Exception $e){
            $retorno['status'] = false;
            $retorno['message'] = "Erro ao atualizar a lista de menus - ". $e->getMessage();
        }

        return $retorno;

    }
}