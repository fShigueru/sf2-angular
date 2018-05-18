<?php

namespace Admin\PaginaBundle\Controller;

use Admin\CommonBundle\Entity\Idioma;
use Admin\ImageBundle\Entity\Image;
use Admin\ImageBundle\Entity\ImageProporcao;
use Admin\PaginaBundle\Entity\Foto;
use Admin\PaginaBundle\Entity\FotoProporcao;
use Admin\PaginaBundle\Entity\PaginaSeo;
use Admin\PaginaBundle\Entity\PaginaTexto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\PaginaBundle\Entity\Pagina;
use Admin\PaginaBundle\Form\PaginaType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pagina controller.
 *
 * @Route("/pagina")
 */
class PaginaController extends Controller
{

    private $path = "pagina";

    /**
     * Lists all Pagina entities.
     *
     * @Route("/", name="pagina")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminPaginaBundle:Pagina')->findBy(array(), array('id'=>'DESC'));
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pagina entity.
     *
     * @Route("/", name="pagina_create")
     * @Method("POST")
     * @Template("AdminPaginaBundle:Pagina:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pagina();

        $seo = new PaginaSeo();
        $texto = new PaginaTexto();
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setThumbH("80");
        $fotoProporcoes->setThumbW("80");
        $foto->addProporcoes($fotoProporcoes);

        $entity->addPaginaSeo($seo);
        $entity->addPaginaTextos($texto);
        $entity->setImage($foto);

        $entity->setCreated(null);
        $entity->setUpdated(null);

            $translated = $this->get('translator');
            $validator = $this->get('validator');
            $session = $this->get('session');

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($entity->getDtPublicacao() == null) {
            $entity->setDtPublicacao($entity->getCreated());
        }

        if ($entity->getCreated() > $entity->getDtPublicacao()) {
            $entity->setDtPublicacao($entity->getCreated());
        }

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView()
        ];

        foreach ($entity->getPaginaTextos() as $paginaTexto) {
            $retornoService = $this->get('admin_pagina.service.pagina')->slug($paginaTexto);
            if ($retornoService['status']) {
                $paginaTexto->setSlug($retornoService['entity']->getSlug());
            } else {
                $session->getFlashBag()->add('error', $translated->transChoice('message.slug.existe',0,array(),'validacaoPaginaBundle'));
                return $retorno;
            }
        }

        /*
         * Upload da imagem enviada
         */
        if ($entity->getImage()->getFile() != null) {
            $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
        }

        if ($form->isValid()) {
            try{
                $this->get('admin_pagina.service.pagina')->insert($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('message.error.cadastrar',0,array(),'validacaoPaginaBundle'));
                return $retorno;
            }

            $this->get('admin_pagina.service.pagina')->addMenu($entity);

            $session->getFlashBag()->add('sucesso', $translated->transChoice('message.cadastro.sucesso',0,array(),'validacaoPaginaBundle'));
            return $this->redirect($this->generateUrl('pagina_show', array('id' => $entity->getId())));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'validacaoPaginaBundle'));
                }
            }
        }

        return $retorno;
    }

    /**
     * Creates a form to create a Pagina entity.
     *
     * @param Pagina $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pagina $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new PaginaType(), $entity, array(
            'action' => $this->generateUrl('pagina_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Pagina entity.
     *
     * @Route("/new", name="pagina_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pagina();

        $seo = new PaginaSeo();
        $texto = new PaginaTexto();
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setCropSizeW("250");
        $fotoProporcoes->setCropSizeH("250");
        $foto->addProporcoes($fotoProporcoes);

        $em = $this->getDoctrine()->getManager();
        $idiomaPt = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');

        $seo->setIdioma($idiomaPt);
        $texto->setIdioma($idiomaPt);

        $entity->setImage($foto);
        $entity->addPaginaSeo($seo);
        $entity->addPaginaTextos($texto);

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pagina entity.
     *
     * @Route("/{id}", name="pagina_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminPaginaBundle:Pagina')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pagina entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pagina entity.
     *
     * @Route("/{id}/edit", name="pagina_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminPaginaBundle:Pagina')->find($id);

        if (!$entity)
            throw $this->createNotFoundException('Unable to find Pagina entity.');


        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Pagina entity.
    *
    * @param Pagina $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pagina $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new PaginaType(), $entity, array(
            'action' => $this->generateUrl('pagina_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Pagina entity.
     *
     * @Route("/{id}", name="pagina_update")
     * @Method("PUT")
     * @Template("AdminPaginaBundle:Pagina:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminPaginaBundle:Pagina')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pagina entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        $retorno = [
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];

        /*
         * Texto da página
         */
        foreach ($entity->getPaginaTextos() as $paginaTexto) {
            $retornoService = $this->get('admin_pagina.service.pagina')->slug($paginaTexto);
            if ($retornoService['status']) {
                $paginaTexto->setSlug($retornoService['entity']->getSlug());
            } else {
                if($retornoService['entity']->getPagina()->getId() != $entity->getId()){
                    $session->getFlashBag()->add('error', $translated->transChoice('message.slug.existe',0,array(),'validacaoPaginaBundle'));
                    return $retorno;
                }
            }
        }

        /*
         * Upload da imagem enviada
         */

        if ($entity->getImage()->getFile() != null) {
            $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
        }

        if ($editForm->isValid()) {

            try{
                $this->get('admin_pagina.service.pagina')->update($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('message.alterado.error',0,array(),'validacaoPaginaBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('message.alterado.sucesso',0,array(),'validacaoPaginaBundle'));
            return $this->redirect($this->generateUrl('pagina_edit', array('id' => $id)));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'validacaoPaginaBundle'));
                }
            }
        }

        return $retorno;
    }
    /**
     * Deletes a Pagina entity.
     *
     * @Route("/{id}", name="pagina_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $session = $this->get('session');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminPaginaBundle:Pagina')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pagina entity.');
            }

            /* Se estiver vinculado na tabela menu, remove */

            try{
                $menu = $em->getRepository('AdminMenuBundle:Menu')->findMenuPagina($entity);
                if ($menu) {
                    $this->get('admin_menu.service.menu')->removeMenu($menu->getId());
                }
            }catch (\Exception $e){
            }


            /* Se existir imagem na aws, remove */
            if(!empty($entity->getImage())){
                if($entity->getImage()->getImage() != null){
                    $this->get('admin_image.service.image')->remover($entity,$this->path);
                }
            }

            try{
                $this->get('admin_pagina.service.pagina')->delete($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('message.delete.error',0,array(),'validacaoPaginaBundle'));
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('message.delete.sucesso',0,array(),'validacaoPaginaBundle'));
        }else{
            $session->getFlashBag()->add('error', $translated->transChoice('message.delete.error',0,array(),'validacaoPaginaBundle'));
        }

        return $this->redirect($this->generateUrl('pagina'));
    }

    /**
     * Creates a form to delete a Pagina entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pagina_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }

    /**
     * Ajax, verifica se o slug da página é unico
     *
     * @Route("/ajax/pagina/verificar-slug/{slug}/{id}", name="pagina-verif-slug", defaults={"id" = null})
     * @Method("GET")
     */
    public function verificarSlug($slug, $id)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $paginaTexto = new PaginaTexto();
        $paginaTexto->setSlug($slug);

        $retorno = ['status' => true];

        $retornoService = $this->get('admin_pagina.service.pagina')->slug($paginaTexto);

        //se existir o slug na base de dados
        if(!$retornoService['status']){
            //se não for o slug do id cadastrado
            if($retornoService['entity']->getPagina()->getId() != $id){
                $retorno = ['status' => false];
            }
        }

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Deleta foto
     *
     * @Route("/ajax/pagina/delete-foto", name="pagina-delete-foto")
     * @Method("POST")
     */
    public function deleteFoto(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminPaginaBundle:Pagina')->find($post->id);

        if (!$entity)
            return $response->setContent(json_encode($retorno));


        //remover imagem
        if ($this->get('admin_image.service.image')->remover($entity,$this->path)) {
            $entity->getImage()->setImage(null);
            try{
                $this->get('admin_pagina.service.pagina')->update($entity);
                $retorno['status'] = true;
            } catch(\Exception $e) {
            }
        }

        return $response->setContent(json_encode($retorno));

    }

    /**
     * Salvar foto
     *
     * @Route("/ajax/pagina/save-foto", name="pagina-save-foto")
     * @Method("POST")
     */
    public function saveFoto(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $encodedData = str_replace(' ','+',$request->request->get('croppedImage'));
        $decodedData = base64_decode($encodedData);

        dump($decodedData);exit;

    }
}
