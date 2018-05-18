<?php

namespace Admin\GaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageGaleriaTextoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',['label' => 'title.titulo' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left']])
            ->add('subtitulo','text', ['label' => 'title.sub' , 'required' => true, 'attr' => ['class' => 'form-control has-feedback-left','maxlength'=>'80']])
            ->add('descricao','textarea', ['label' => 'title.descricao' , 'required' => true, 'attr' => ['class' => 'form-control tinymce','maxlength'=>'200']])
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
            'data_class' => 'Admin\GaleriaBundle\Entity\ImageGaleriaTexto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_galeriabundle_imagegaleriatexto';
    }
}
