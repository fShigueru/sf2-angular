<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class ContatoType extends AbstractType {

    /**
     * definimos os campos, e trabalhamos com seus tipos..
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text', ['label' => false , 'attr' => ['class' => 'form-control', 'required' => true, 'placeholder' => 'label.contato.nome','ng-model'=>'nome','ng-minlength'=>'5']])
            ->add('email', 'email', ['label' => false , 'attr' => ['class' => 'form-control','required' => true, 'placeholder' => 'label.contato.email','ng-model'=>'email']])
            ->add('telefone', 'text', ['label' => false , 'attr' => ['class' => 'form-control','required' => false, 'placeholder' => 'label.contato.telefone','ng-model'=>'telefone']])
            ->add('mensagem', 'textarea', ['label' => false ,'required' => true, 'attr' => ['class' => 'form-control textarea-mensagem', 'placeholder' => 'label.contato.mensagem', 'rows'=>'8', 'cols'=>'12','ng-model'=>'mensagem']])
            ->add('enviar', 'button', ['label' => 'label.contato.enviar' ,'attr' => ['class' => 'btn btn-default submit-btn form_submit','ng-click'=>'sendEmail()','ng-disabled'=>'myFormContato.$invalid']])
        ;
    }

    /**
     * Faz a ligação entre o form e a entidade
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaulOptions(OptionsResolverInterface $resolver)
    {
        //dessa forma amarramos o form com a entidade
        $resolver->setDefaults(
            ['data_class' => 'AppBundle\Entity\Contato','csrf_protection' => false]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "appbundle_contatotype";
    }
}