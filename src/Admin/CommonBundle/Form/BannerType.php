<?php

namespace Admin\CommonBundle\Form;

use Admin\ImageBundle\Form\ImageType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerType extends AbstractType
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

        $banners = $options['local'];

        $builder
            ->add('titulo','text',['label' => 'title.titulo' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left']])
            ->add('url','url',['label' => 'title.url' , 'required' => true,'attr'=> ['class' => 'form-control has-feedback-left','placeholder' => 'title.url.formato']])
            ->add('status', 'choice', [
                'choices' => $status,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'label' => 'title.status',
                'translation_domain' => 'messagesCommonBundle',
                'empty_value' => false,
                'empty_data' =>  1,
                'data' => 1,
                'attr' => ['class' => 'flat']
            ])
            ->add('dtPublicacao','date',
                ['label' => 'title.data.publicacao',
                    'required' => false,
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
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                    'translation_domain' => 'messagesCommonBundle',
                    'empty_data' => new \DateTime("now"),
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
                'empty_data' => '_blank',
                'data' => '_blank',
                'attr' => [
                    'class' => ''
                ]
            ])
            ->add('image',new ImageType(),['required' => true])
            //->add('local',null, ['label' => 'title.local', 'required' => true, 'attr' => ['class' => 'select2_single form-control','onchange'=>'getLocalBanner()']])
            ->add('local', 'entity', [
                    'label' => 'title.local' ,
                    'class' => 'Admin\CommonBundle\Entity\LocalBanner',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'placeholder' => '-- Selecione o tamanho da imagem --',
                    'query_builder' => function (EntityRepository $er)  use ($banners) {
                        if(empty($banners)){
                            return $er->createQueryBuilder('l')
                                ->orderBy('l.id', 'DESC');
                        }else{
                            return $er->createQueryBuilder('l')
                                ->where("l.id NOT IN (:banners)")
                                ->setParameter(":banners",$banners)
                                ->orderBy('l.id', 'DESC');
                        }
                    },
                    'attr' => ['class' => 'select2_single form-control','onchange'=>'getLocalBanner()']
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
            'data_class' => 'Admin\CommonBundle\Entity\Banner',
            //'cascade_validation' => true
        ));
        $resolver->setRequired(array(
            'local'
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_commonbundle_banner';
    }
}
