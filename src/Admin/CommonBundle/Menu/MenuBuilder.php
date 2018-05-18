<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/03/2016
 * Time: 21:24
 */

namespace Admin\CommonBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuBuilder
{
    private $factory;
    private $translator;
    private $auth;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Translator $translator,AuthorizationChecker $auth)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->auth = $auth;
    }

    /**
     * Menu admin, topo a direita
     *
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createHeaderMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'dropdown-menu dropdown-usermenu animated fadeInDown pull-right');
        //Perfil do usuário que está acessando o sistema
        $menu->addChild('<i class="fa fa-user pull-right"></i>'.$this->translator->transChoice('txt.sistema.menu.top.right.usuario.ver',0,[],'messagesUserBundle'),
                        ['route' => 'fos_user_profile_show','extras' => ['safe_label' => true]]);

        //Editar o perfil do usuário que está acessando o sistema
        $menu->addChild('<i class="fa fa-edit pull-right"></i>'.$this->translator->transChoice('txt.sistema.menu.top.right.usuario.editar.dados',0,[],'messagesUserBundle'),
                        ['route' => 'fos_user_profile_edit','extras' => ['safe_label' => true]]);

        //Cadastrar um novo usuário para o sistema
        if($this->auth->isGranted(['ROLE_ADMIN','ROLE_USER_ADMIN']))
            $menu->addChild('<i class="fa fa-save pull-right"></i>'.$this->translator->transChoice('txt.sistema.menu.top.right.cadastrar.usuario',0,[],'messagesUserBundle'), ['route' => 'fos_user_registration_register','extras' => ['safe_label' => true]]);

        //Listar os usuários cadastrados no sistema
        if($this->auth->isGranted(['ROLE_ADMIN','ROLE_USER_ADMIN']))
            $menu->addChild('<i class="fa fa-list-alt pull-right"></i>'.$this->translator->transChoice('title.usuario.lista',0,[],'messagesUserBundle'), ['route' => 'user','extras' => ['safe_label' => true]]);

        //Editar a senha do usuário que está acessando o sistema
        $menu->addChild('<i class="fa fa-key pull-right"></i>'.$this->translator->transChoice('txt.sistema.menu.top.right.usuario.editar.senha',0,[],'messagesUserBundle'),
                        ['route' => 'fos_user_change_password','extras' => ['safe_label' => true]]);

        //Logout
        $menu->addChild('<i class="fa fa-sign-out pull-right"></i>'.$this->translator->transChoice('title.sistema.sair',0,[],'sistema'),
                        ['route' => 'fos_user_security_logout','extras' => ['safe_label' => true]]);
        return $menu;
    }


    /**
     * Menu admin, a esquerda
     *
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function createLeftMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav side-menu');
        //Dashboard
        $menu->addChild('<i class="fa fa-dashboard"></i>'.$this->translator->transChoice('title.sistema.menu.left.dashboard',0,[],'sistema'), ['route' => 'dashboard','extras' => ['safe_label' => true]]);
        //Estado-Cidade-Bairro
        $menuLogradouro = $menu->addChild('<i class="fa fa-road"></i>'.$this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro',0,[],'messagesEnderecoBundle').'<span class="fa fa-chevron-down"></span>', ['uri' => 'javascript://logradouros','extras' => ['safe_label' => true]])
            ->setChildrenAttributes(['class'=>'nav child_menu','style'=>'display:none']);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.estado.cadastrar',0,[],'messagesEnderecoBundle'), ['route' => 'estado_new','extras' => ['safe_label' => true]]);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.estado.listar',0,[],'messagesEnderecoBundle'), ['route' => 'estado','extras' => ['safe_label' => true]]);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.cidade.cadastrar',0,[],'messagesEnderecoBundle'), ['route' => 'cidade_new','extras' => ['safe_label' => true]]);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.cidade.listar',0,[],'messagesEnderecoBundle'), ['route' => 'cidade','extras' => ['safe_label' => true]]);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.bairro.cadastrar',0,[],'messagesEnderecoBundle'), ['route' => 'bairro_new','extras' => ['safe_label' => true]]);
            $menuLogradouro->addChild($this->translator->transChoice('txt.sistema.menu.left.EstadoCidadeBairro.bairro.listar',0,[],'messagesEnderecoBundle'), ['route' => 'bairro','extras' => ['safe_label' => true]]);
        //Vitrine
        $menuVitrine = $menu->addChild('<i class="fa fa-file-image-o"></i>'.$this->translator->transChoice('title.vitrine',0,[],'messagesVitrineCommonBundle').'<span class="fa fa-chevron-down"></span>', ['uri' => 'javascript://Vitrine','extras' => ['safe_label' => true]])
            ->setChildrenAttributes(['class'=>'nav child_menu','style'=>'display:none']);
            $menuVitrine->addChild($this->translator->transChoice('title.vitrine.cadastrar',0,[],'messagesVitrineCommonBundle'), ['route' => 'vitrine_new','extras' => ['safe_label' => true]]);
            $menuVitrine->addChild($this->translator->transChoice('title.vitrine.listar',0,[],'messagesVitrineCommonBundle'), ['route' => 'vitrine','extras' => ['safe_label' => true]]);
        //Pagina
        $menuPagina = $menu->addChild('<i class="fa fa-file-excel-o"></i>'.$this->translator->transChoice('title.pagina',0,[],'messagesPaginaBundle').'<span class="fa fa-chevron-down"></span>', ['uri' => 'javascript://Pagina','extras' => ['safe_label' => true]])
            ->setChildrenAttributes(['class'=>'nav child_menu','style'=>'display:none']);
            $menuPagina->addChild($this->translator->transChoice('title.nova',0,[],'messagesPaginaBundle'), ['route' => 'pagina_new','extras' => ['safe_label' => true]]);
            $menuPagina->addChild($this->translator->transChoice('title.pagina.listar',0,[],'messagesPaginaBundle'), ['route' => 'pagina','extras' => ['safe_label' => true]]);
        //Banner
        $menuPagina = $menu->addChild('<i class="fa fa-photo"></i>'.$this->translator->transChoice('title.banner',0,[],'messagesBannerCommonBundle').'<span class="fa fa-chevron-down"></span>', ['uri' => 'javascript://Pagina','extras' => ['safe_label' => true]])
            ->setChildrenAttributes(['class'=>'nav child_menu','style'=>'display:none']);
            $menuPagina->addChild($this->translator->transChoice('title.cadastrar',0,[],'messagesBannerCommonBundle'), ['route' => 'banner_new','extras' => ['safe_label' => true]]);
            $menuPagina->addChild($this->translator->transChoice('title.listar',0,[],'messagesBannerCommonBundle'), ['route' => 'banner','extras' => ['safe_label' => true]]);
            $menuPagina->addChild($this->translator->transChoice('title.local.menu.cadastrar',0,[],'messagesLocalBannerCommonBundle'), ['route' => 'localbanner_new','extras' => ['safe_label' => true]]);
            $menuPagina->addChild($this->translator->transChoice('title.local.menu.list',0,[],'messagesLocalBannerCommonBundle'), ['route' => 'localbanner','extras' => ['safe_label' => true]]);
        //Vitrine
        $menuGaleria = $menu->addChild('<i class="fa fa-qrcode"></i>'.$this->translator->transChoice('title.galeria',0,[],'messagesGaleriaBundle').'<span class="fa fa-chevron-down"></span>', ['uri' => 'javascript://Galeria','extras' => ['safe_label' => true]])
            ->setChildrenAttributes(['class'=>'nav child_menu','style'=>'display:none']);
            $menuGaleria->addChild($this->translator->transChoice('title.galeria.cadastrar',0,[],'messagesGaleriaBundle'), ['route' => 'galeria_new','extras' => ['safe_label' => true]]);
            $menuGaleria->addChild($this->translator->transChoice('title.galeria.list',0,[],'messagesGaleriaBundle'), ['route' => 'galeria','extras' => ['safe_label' => true]]);
        //Menu
        $menu->addChild('<i class="fa fa-navicon"></i>'.$this->translator->transChoice('title.menu.2',1,[],'messagesMenuBundle'), ['route' => 'menu','extras' => ['safe_label' => true]]);

        return $menu;
    }
}