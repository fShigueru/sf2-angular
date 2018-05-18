<?php

namespace Admin\PaginaBundle\Form;

use Admin\CommonBundle\Form\IdiomaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaginaTextoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',['label' => 'title.titulo' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-change'=>'slug(slugView)','ng-model'=>'slugView','ng-blur'=>'verificaSlug(mySlug)']])
            ->add('subTitulo','text', ['label' => 'title.sub' , 'required' => true, 'attr' => ['class' => 'form-control has-feedback-left','maxlength'=>'150']])
            ->add('descricao','textarea', ['label' => 'title.descricao' , 'required' => true, 'attr' => ['class' => 'form-control tinymce', 'data-theme' => 'bbcode']])
            ->add('slug','text',['label' => 'title.slug' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-model'=>'mySlug','ng-blur'=>'verificaSlug(mySlug)']])
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
            'data_class' => 'Admin\PaginaBundle\Entity\PaginaTexto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_paginabundle_paginatexto';
    }
}
