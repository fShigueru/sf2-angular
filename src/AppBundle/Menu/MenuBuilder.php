<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/03/2016
 * Time: 21:24
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class MenuBuilder
{
    private $factory;
    private $translator;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Translator $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu->addChild($this->translator->transChoice('menu.home',0,array(),'messages'), ['uri' => '#home']);
        $menu->addChild($this->translator->transChoice('menu.servico',1,array(),'messages'), ['uri' => '#servicos']);
        $menu->addChild($this->translator->transChoice('menu.trabalho',1,array(),'messages'), ['uri' => '#trabalhos']);
        $menu->addChild($this->translator->transChoice('menu.contato',0,array(),'messages'), ['uri' => '#contato']);

        return $menu;
    }

    public function createFooterMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav footer-menu');

        $menu->addChild($this->translator->transChoice('menu.home',0,array(),'messages'), ['uri' => '#home']);
        $menu->addChild($this->translator->transChoice('menu.servico',1,array(),'messages'), ['uri' => '#servicos']);
        $menu->addChild($this->translator->transChoice('menu.trabalho',1,array(),'messages'), ['uri' => '#trabalhos']);
        $menu->addChild($this->translator->transChoice('menu.contato',0,array(),'messages'), ['uri' => '#contato']);

        return $menu;
    }
}