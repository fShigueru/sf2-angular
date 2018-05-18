<?php

namespace Admin\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocalBannerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('local', 'text', ['label' => 'title.local' ,'required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('width', 'number', ['label' => 'title.width' ,'required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('height', 'number', ['label' => 'title.height' ,'required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CommonBundle\Entity\LocalBanner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_commonbundle_localbanner';
    }
}
