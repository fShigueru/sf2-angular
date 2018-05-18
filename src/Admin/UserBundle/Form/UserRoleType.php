<?php

namespace Admin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRoleType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $permissions = array(
            'ROLE_SIMPLES' => 'Usuário simples',
            'ROLE_USER' => 'Usuário do sistema',
            'ROLE_USER_ADMIN' => 'Usuário com acesso aos users'
        );

        $id = $options['id'];
        $selectdRole = $options['selectdRole'];

        $builder
            ->add('id','hidden',['data' => $id, 'mapped' =>false])
            ->add(
                'role',
                'choice',
                [
                    'label'   => 'title.role.alterar',
                    'choices' => $permissions,
                    'data'    => $selectdRole,
                    'multiple' => true,
                    'attr' => ['class' => 'select2_multiple form-control']
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
        $resolver->setRequired(array(
            'id','selectdRole'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_role';
    }
}
