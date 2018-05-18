<?php

namespace Admin\PaginaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginaSeoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao','textarea', ['label' => 'title.descricao' , 'required' => true, 'attr' => ['class' => 'form-control','maxlength'=>'155']])
            ->add('keyWord','text', ['label' => 'title.keyWord' , 'required' => true, 'attr' => ['class' => 'tags form-control has-feedback-right','maxlength'=>'155']])
            ->add('idioma', 'entity_hidden', [
                'class' => 'Admin\CommonBundle\Entity\Idioma',
                'property' => 'sigla'
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\PaginaBundle\Entity\PaginaSeo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_paginabundle_paginaseo';
    }
}
