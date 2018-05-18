<?php

namespace Admin\NoticiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoticiaCategoriaType extends AbstractType
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
                'attr' => ['class' => 'flat']
            ])
            ->add('textos', 'collection', [
                    'label' => false,
                    'type' => new NoticiaCategoriaTextoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'prototype' => false
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\NoticiaBundle\Entity\NoticiaCategoria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_noticiabundle_noticiacategoria';
    }
}
