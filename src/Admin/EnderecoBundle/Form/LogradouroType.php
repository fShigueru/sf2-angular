<?php

namespace Admin\EnderecoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogradouroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logradouro', 'text', ['label' => 'txt.logradouro' ,'required' => true, 'attr' => ['class' => 'form-control','data-validate-length-range' => '6']])
            ->add('numero', 'integer', ['label' => 'txt.numero' ,'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('complemento', 'text', ['label' => 'txt.complemento' ,'required' => false, 'attr' => ['class' => 'form-control']])
            ->add('cep', 'text', ['label' => 'txt.cep' ,'required' => true, 'attr' => ['class' => 'form-control']])
            ->add('bairro', null, ['label' => 'txt.bairro' ,'required' => true, 'attr' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'title.bairro.selecione', 'choices_as_values' => true]])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\EnderecoBundle\Entity\Logradouro',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_enderecobundle_logradouro';
    }
}