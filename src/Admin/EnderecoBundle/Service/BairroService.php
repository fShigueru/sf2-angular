<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 23/08/2015
 * Time: 14:37
 */

namespace Admin\EnderecoBundle\Service;

use Admin\EnderecoBundle\Entity\Bairro;
use Admin\EnderecoBundle\Entity\EstadoInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\Admin\EnderecoBundle\Entity\Cidade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormFactory;

class BairroService {

    private $em;
    private $form;

    public function __construct(EntityManagerInterface $em, FormFactory $form)
    {
        $this->em = $em;
        $this->form = $form;
    }

    /**
     *
     * Cria um novo bairro com um request em ajax
     *
     * @param Request $request
     * @return Bairro
     */
    public function ajaxCreate(Request $request)
    {
        $entity = new Bairro();
        $entityCidade = $this->em->getRepository('AdminEnderecoBundle:Cidade')->find($request->get("cidade"));
        $entity->setCidade($entityCidade);
        $entity->setNome($request->get("bairro"));

        if($this->em->getRepository('AdminEnderecoBundle:Bairro')->validarSeBairroDuplicado($entity) != null){
            throw new Exception("Esse bairro já existe para essa cidade");
        }else{
            $list = [];
            try{
                $this->em->persist($entity);
                $this->em->flush();
            } catch (\Exception $e){
                throw new Exception("Erro ao persistir o bairro : " . $e->getMessage());
            }
        }
        return $entity;
    }

}