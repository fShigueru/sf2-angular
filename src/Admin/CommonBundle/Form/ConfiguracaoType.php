<?php

namespace Admin\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfiguracaoType extends AbstractType
{

    private $isGranted;
    /**
     * ConfiguracaoType constructor.
     */
    public function __construct($roleFlag)
    {
        $this->isGranted = $roleFlag;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao','text',['label' => 'txt.descricao','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('valor','text',['label' => 'title.valor','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
        ;


        if($this->isGranted) {
            $builder->add('chave','text',['label' => 'title.chave','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']]);
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CommonBundle\Entity\Configuracao'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_commonbundle_configuracao';
    }
}
