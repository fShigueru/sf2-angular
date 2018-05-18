<?php

namespace Admin\GaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageGaleriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file','file',['label' => 'title.image.selecionar', 'required' => true, 'attr' => ['style'=>'display:none','class'=>'cropit-image-input']])
            ->add('textos', 'collection', [
                    'label' => false,
                    'type' => new ImageGaleriaTextoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'prototype' => false
                ]
            )
            ->add('proporcoes', new GaleriaProporcaoType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\GaleriaBundle\Entity\ImageGaleria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_galeriabundle_imagegaleria';
    }
}
