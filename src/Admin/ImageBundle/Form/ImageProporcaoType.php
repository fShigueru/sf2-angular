<?php

namespace Admin\ImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageProporcaoType extends AbstractType
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
            ->add('cropSizeW','hidden')
            ->add('cropSizeH','hidden')
            ->add('scale','hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\ImageBundle\Entity\ImageProporcao'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_imagebundle_imageproporcao';
    }
}
