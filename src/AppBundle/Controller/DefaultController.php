<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contato;
use AppBundle\Form\ContatoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Liip\ImagineBundle\Binary\Loader\StreamLoader;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:default:index.html.twig", vars={"controller" = "Default"})
     */
    public function indexAction()
    {
        $entity = new Contato();
        $form = $this->createForm(new ContatoType(), $entity, []);

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/proximamente", name="proximamente")
     * @Template("AppBundle:default:espera.html.twig")
     */
    public function esperaAction()
    {

        /*
        $filesystem = $this->get('knp_gaufrette.filesystem_map')->get('photo_storage');
        $file = $filesystem->get('pagina/2016/03/24/56f406492079e.png');

        dump($file);die;

        $image = $this->getParameter('amazon_s3_base_url'). '/' .
            $this->getParameter('amazon_s3_bucket_name'). '/' .
            'pagina/2016/03/24/56f406492079e.png';

        */
/*
        $filesystem = $this->get('knp_gaufrette.filesystem_map')->get('photo_storage');
        $file = $filesystem->get('pagina/2016/03/24/56f406492079e.png');
        $crop = $this->get('liip_imagine.filter.loader.crop');
        $aa = $crop->load($file, ['start' => [500, 200],'size'=> [200, 200]]);
        dump($file);exit;

        $filesystem = $this->get('knp_gaufrette.filesystem_map')->get('photo_storage');
        $file = $filesystem->get('pagina/2016/03/24/56f406492079e.png');

        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $a = $cacheManager->getBrowserPath('pagina/2016/03/24/56f406492079e.png','test_medium_thumb');
        $cacheManager->remove([$a]);
        dump($a);exit;

        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $cacheManager->remove([$file],['test_medium_thumb']);
        exit;


        $filesystem = $this->get('knp_gaufrette.filesystem_map')->get('photo_storage');
        $file = $filesystem->get('pagina/2016/03/24/56f406492079e.png');
        dump($file);exit;

       $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $a = $cacheManager->getBrowserPath('pagina/2016/03/24/56f406492079e.png','test_medium_thumb');
        $b = $cacheManager->isStored($a,'test_medium_thumb');
        dump($b);exit;
        $filesystem = $this->get('knp_gaufrette.filesystem_map')->get('photo_storage');
        $file = $filesystem->get('pagina/2016/03/24/56f406492079e.png');
        dump($file);exit;
*/

        $image = 'pagina/2016/03/24/56f406492079e.png';
        $crop = [
            'start' => [146.6, 49.6],
            'size'  => [250, 250]
        ];
        $scale = 0.16816074188562596;
        return [
            'image' => $image,
            'crop' => $crop,
            'scale'  => $scale
        ];

    }
}
