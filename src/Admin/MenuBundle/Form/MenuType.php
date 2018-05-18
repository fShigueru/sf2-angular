<?php

namespace Admin\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome','text',['label' => 'title.titulo' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-model'=>'nome']])
            ->add('url','url',['label' => 'title.link' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-model'=>'url']])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MenuBundle\Entity\Menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_menubundle_menu';
    }
}
