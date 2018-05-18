<?php

namespace Admin\GaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleriaIdEntityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $iniciar = $options['iniciar'];
        $default = $options['default'];
        $builder
            ->add('idEntity', 'choice', [
                    'choices' => $iniciar,
                    'label' => 'title.galeria.vincular.com.registro',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'placeholder' => '--Selecione um registro--',
                    'data' => $default,
                    'attr' => ['class' => 'select2_single form-control']
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
            'data_class' => null
        ));
        $resolver->setRequired(array(
            'iniciar',
            'default'
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_galeriabundle_idEntity';
    }
}
