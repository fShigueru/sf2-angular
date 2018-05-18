<?php

namespace Admin\EnderecoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sigla', 'text', ['label' => 'txt.sigla' ,'required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('descricao', 'text', ['label' => 'txt.descricao' ,'required' => false, 'attr' => ['class' => 'form-control has-feedback-left']])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\EnderecoBundle\Entity\Estado'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_enderecobundle_estado';
    }
}
