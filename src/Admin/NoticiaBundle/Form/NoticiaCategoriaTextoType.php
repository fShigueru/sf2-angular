<?php

namespace Admin\NoticiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoticiaCategoriaTextoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome','text',['label' => 'txt.nome' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-change'=>'slug(slugView)','ng-model'=>'slugView','ng-blur'=>'verificaSlug(mySlug)','ng-required'=>'true']])
            ->add('slug','text',['label' => 'title.slug' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','ng-model'=>'mySlug','ng-blur'=>'verificaSlug(mySlug)','ng-required'=>'true']])
            ->add('idioma', 'entity_hidden', [
                'class' => 'Admin\CommonBundle\Entity\Idioma',
                'property' => 'sigla',
                'label' => false
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\NoticiaBundle\Entity\NoticiaCategoriaTexto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_noticiabundle_noticiacategoriatexto';
    }
}
