<?php

namespace Admin\MenuBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\MenuBundle\Entity\Menu;
use Admin\MenuBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menu controller.
 *
 * @Route("/menu")
 */
class MenuController extends Controller
{

    /**
     * Lists all Menu entities.
     *
     * @Route("/", name="menu")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new Menu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entitiesAtivo' => $this->get('admin_menu.service.menu')->getMenusAtivo(),
            'entitiesInativo' => $this->get('admin_menu.service.menu')->getMenusInativo(),
            'form'   => $form->createView(),
        );

    }
    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="menu_create")
     * @Method("POST")
     * @Template("AdminMenuBundle:Menu:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('menu_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Salva um novo menu por ajax
     *
     * @Route("/ajax/create", name="menu_create_ajax")
     * @Method("POST")
     */
    public function createAjax(Request $request)
    {

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();

        $entity = new Menu();
        $entity->setNome($post->nome);
        $entity->setUrl($post->url);
        $entity->setStatus(0);
        $entity->setPosicao(0);

        $retorno = $this->get('admin_menu.service.menu')->addMenuUrl($entity);
        if($retorno['status']){
            $translated = $this->get('translator');
            $retorno['id'] = $entity->getId();
            $retorno['messageTitleDelete'] = $translated->transChoice('title.delete',0,array(),'messagesMenuBundle');
        }

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_create'),
            'method' => 'POST',
        ));

        $form->add('button', 'button', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg','ng-click'=>'saveMenu()')));

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="menu_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Menu();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Menu entity.
     *
     * @Route("/{id}", name="menu_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminMenuBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="menu_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminMenuBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Menu entity.
    *
    * @param Menu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="menu_update")
     * @Method("PUT")
     * @Template("AdminMenuBundle:Menu:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminMenuBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Menu entity.
     *
     * @Route("/{id}", name="menu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminMenuBundle:Menu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Menu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * Pega lista
     *
     * @Route("/ajax/lista", name="menu-get-lista")
     * @Method("POST")
     */
    public function listaMenu(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $retorno = $this->get('admin_menu.service.menu')->updateMenuLista($post);

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Exclui um menu do banco de dados
     *
     * @Route("/ajax/delete", name="menu-delete-lista")
     * @Method("POST")
     */
    public function deleteAjax(Request $request)
    {

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $id = $post->id;
        $retorno = $this->get('admin_menu.service.menu')->removeMenu($id);

        return $response->setContent(json_encode($retorno));
    }
}
