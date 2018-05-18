<?php

namespace Admin\CommonBundle\Form;

use Admin\ImageBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VitrineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $status = [
            1 => 'txt.ativo',
            0 => 'txt.inativo'
        ];

        $optionsTarget = [
            '_blank'  => 'Abrir em nova aba',
            '_self' => 'Abrir na mesma aba'
        ];

        $builder
            ->add('titulo','text',['label' => 'title.titulo','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('url','url',['label' => 'title.url','required' => false,'translation_domain' => 'messagesCommonBundle', 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('image',new ImageType())
            ->add('ordem',null,['label' => 'title.ordem','required' => false, 'attr' => ['class' => 'form-control has-feedback-left', 'min' => '0','max'=>'4']])
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
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'attr' => [
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'title.data.publicacao',
                        'aria-describedby'=>'inputSuccess2Status2'
                ]])
            ->add('dtExpiracao','date',
                ['label' => 'title.data.expiracao',
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'attr' => [
                        'class' => 'form-control has-feedback-left',
                        'placeholder' => 'title.data.expiracao',
                        'aria-describedby'=>'inputSuccess2Status2'
                ]])
            ->add('target', 'choice', [
                'choices' => $optionsTarget,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'label' => 'title.url.abrir',
                'empty_value' => false,
                'translation_domain' => 'messagesCommonBundle',
                'attr' => [
                    'class' => ''
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CommonBundle\Entity\Vitrine'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_commonbundle_vitrine';
    }
}
