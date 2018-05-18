<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\UserBundle\Form;

use Admin\ImageBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',new ImageType())
            ->add('nome','text',['label' => 'txt.nome','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
            ->add('sobrenome','text',['label' => 'title.sobrenome','required' => true, 'attr' => ['class' => 'form-control has-feedback-left']])
        ;
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
