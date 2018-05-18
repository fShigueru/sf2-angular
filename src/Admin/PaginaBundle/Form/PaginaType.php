<?php

namespace Admin\PaginaBundle\Form;

use Admin\ImageBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $status = [
            1 => 'txt.ativo',
            0 => 'txt.inativo'
        ];

        $builder
            ->add('status', 'choice', [
                'choices' => $status,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'label' => 'title.status',
                'translation_domain' => 'messagesCommonBundle',
                'empty_value' => false,
                'empty_data' =>  1,
                'data' => 1,
                'attr' => ['class' => 'flat']
            ])
            ->add('dtPublicacao','date',
                ['label' => 'title.data.publicacao',
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'empty_data' => new \DateTime("now"),
                    'attr' => [
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'title.data.publicacao',
                        'aria-describedby'=>'inputSuccess2Status2'
                    ]])
            ->add('paginaSeo', 'collection', [
                    'type' => new PaginaSeoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]
            )
            ->add('paginaTextos', 'collection', [
                    'type' => new PaginaTextoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]
            )
            ->add('image',new ImageType())
            ->add('id','hidden',['data' => null, 'mapped' =>false])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\PaginaBundle\Entity\Pagina',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_paginabundle_pagina';
    }
}
