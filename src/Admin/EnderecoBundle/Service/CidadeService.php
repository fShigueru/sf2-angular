<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 24/07/2015
 * Time: 18:47
 */

namespace Admin\EnderecoBundle\Service;

use Admin\EnderecoBundle\Entity\EstadoInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;


class CidadeService {

    private $em;
    private $form;
    private $translator;

    public function __construct(EntityManagerInterface $em, FormFactory $form, Translator $translator )
    {
        $this->em = $em;
        $this->form = $form;
        $this->translator = $translator;
    }

    public function retornarFormList($selected = null)
    {

        $selectedTxt = $this->translator->transChoice('txt.select',0,array(),'messagesCommonBundle');
        $data = array(0 => $selectedTxt);

        if($selected != null){
            $cidade = $this->em->getRepository('AdminEnderecoBundle:Cidade')->find($selected);
            $data[$cidade->getId()] = $cidade->getNome();
        }else{
            $cidades = $this->em->getRepository('AdminEnderecoBundle:Cidade')->findAll();
            foreach($cidades as $cidade){
                $data[$cidade->getId()] = $cidade->getNome();
            }
        }

        return $this->form->createBuilder('form', $data, [])->add('cidades', 'choice', ['label' => 'txt.cidade' ,'choices' => $data, 'data' => $selected, 'required' => 'required','attr' => ['class' =>'form-control has-feedback-left']])->getForm();
    }
}