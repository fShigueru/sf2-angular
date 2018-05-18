<?php

namespace Admin\EnderecoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CidadeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text', ['label' => 'txt.cidade' ,'required' => false, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('estado',null,['label' => 'txt.estado', 'attr' => ['class' => 'form-control has-feedback-left']])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\EnderecoBundle\Entity\Cidade'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_enderecobundle_cidade';
    }
}
