<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/08/2015
 * Time: 19:19
 */

namespace Admin\CommonBundle\Service\Configuracao;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class ConfiguracaoService implements IConfiguracaoService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function valor($key)
    {
        $entity = $this->em->getRepository("AdminCommonBundle:Configuracao")->porChave($key);
        if($entity != null){
            return $entity->getValor();
        }
        return null;
    }

}