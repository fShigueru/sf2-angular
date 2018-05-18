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

class EstadoService {

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

        $estados = $this->em->getRepository('AdminEnderecoBundle:Estado')->findAll();

        $selectedTxt = $this->translator->transChoice('txt.select',0,array(),'messagesCommonBundle');
        $data = array(0 => $selectedTxt);

        foreach($estados as $estado){
            $data[$estado->getSigla()] = $estado->getSigla();
        }

        return $this->form->createBuilder('form', $data, [])->add('estados', 'choice', ['label' =>  'txt.estado', 'translation_domain' => 'messagesEnderecoBundle' ,'choices' => $data, 'data' => $selected, 'required' => 'required','attr' => ['class' =>'form-control has-feedback-left']])->getForm();
    }

}