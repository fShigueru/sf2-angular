<?php

namespace Admin\CommonBundle\Twig\Extension;

class CommonExtensionGetClass extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('get_class', array($this, 'getClass')),
        );
    }

    public function getClass($entity)
    {
        $retorno = explode("\\", get_class($entity));
        if(empty($retorno)){
            return null;
        }
        return end($retorno);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'common_extension_get_class';
    }
}
