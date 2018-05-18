<?php

namespace Admin\GaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleriaProporcaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cropStartLeft','hidden')
            ->add('cropStartTop','hidden')
            ->add('scale','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\GaleriaBundle\Entity\GaleriaProporcao'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_galeriabundle_galeriaproporcao';
    }
}
