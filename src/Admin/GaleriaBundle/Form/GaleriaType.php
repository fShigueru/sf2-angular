<?php

namespace Admin\GaleriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GaleriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = [
            'AdminPaginaBundle:Pagina' => 'Página',
            'AdminNoticiaBundle:Noticia' => 'Noticia',
            'Home' => 'Home',
            'Contato' => 'Contato'
        ];
        $status = [
            1 => 'txt.ativo',
            0 => 'txt.inativo'
        ];

        $builder
            ->add('titulo','text',['label' => 'title.titulo' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left']])
            ->add('entity', 'choice', [
                    'choices' => $entity,
                    'label' => 'title.galeria.vincular.com' ,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'placeholder' => '-- Selecione --',
                    'attr' => ['class' => 'form-control','ng-change'=>'buscarRegistro()','ng-model'=>'itemEntity']
                ]
            )
            ->add('image', 'collection', [
                    'label' => false,
                    'type' => new ImageGaleriaType(),
                    'cascade_validation' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'required' => false
                ]
            )
            ->add('cropSizeW','hidden')
            ->add('cropSizeH','hidden')
            ->add('status', 'choice', [
                'choices' => $status,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'label' => 'title.status',
                'translation_domain' => 'messagesCommonBundle',
                'empty_value' => false,
                'empty_data' =>  1,
                'attr' => ['class' => 'flat']
            ])
            ->add('dtPublicacao','date',
                ['label' => 'title.data.publicacao',
                    'required' => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'empty_data' => new \DateTime("now"),
                    'attr' => [
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'title.data.publicacao',
                        'aria-describedby'=>'inputSuccess2Status2'
                    ]])
            ->add('dtExpiracao','date',
                ['label' => 'title.data.expiracao',
                    'required' => true,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'empty_data' => new \DateTime("now"),
                    'attr' => [
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'title.data.expiracao',
                        'aria-describedby'=>'inputSuccess2Status2'
                    ]])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\GaleriaBundle\Entity\Galeria',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_galeriabundle_galeria';
    }
}
