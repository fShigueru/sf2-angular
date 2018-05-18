<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 31/07/2015
 * Time: 19:11
 */

namespace Admin\StorageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class PhotoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('photo', 'file', array(
            'label' => 'Photo',
        ));
    }

    public function getName()
    {
        return 'photo';
    }

}