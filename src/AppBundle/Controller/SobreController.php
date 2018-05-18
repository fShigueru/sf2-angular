<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SobreController extends Controller
{

    /**
     * @Route("/sobre", name="app_sobre")
     * @Method("GET")
     * @Template(vars={"controller" = "Sobre"})
     */
    public function indexAction()
    {
        return [];
    }
}
