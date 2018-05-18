<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function init()
    {
        // get rid of Warning: date_default_timezone_get(): It is not safe to rely on the system's timezone
        date_default_timezone_set( 'America/Sao_Paulo' );
        parent::init();
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Admin\UserBundle\AdminUserBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Admin\EnderecoBundle\AdminEnderecoBundle(),
            new Admin\CommonBundle\AdminCommonBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Admin\StorageBundle\AdminStorageBundle(),
            new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
            new Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle(),
            new Admin\PaginaBundle\AdminPaginaBundle(),
            new Glifery\EntityHiddenTypeBundle\GliferyEntityHiddenTypeBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Presta\SitemapBundle\PrestaSitemapBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Admin\MenuBundle\AdminMenuBundle(),
            new Admin\ImageBundle\AdminImageBundle(),
            new Admin\GaleriaBundle\AdminGaleriaBundle(),
            new Admin\NoticiaBundle\AdminNoticiaBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test', 'prod'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
