<?php

namespace Admin\EnderecoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BairroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text', ['label' =>  'txt.bairro', 'translation_domain' => 'messagesEnderecoBundle' , 'required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('cidade',null, ['label' => 'title.bairro.selecione_cidade' , 'required' => true, 'attr' => ['class' =>'form-control has-feedback-left']])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\EnderecoBundle\Entity\Bairro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_enderecobundle_bairro';
    }
}
