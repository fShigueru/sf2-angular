<?php

namespace Admin\CommonBundle\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\CommonBundle\Entity\Configuracao;
use Admin\CommonBundle\Form\ConfiguracaoType;

/**
 * Configuracao controller.
 *
 * @Route("/configuracao")
 */
class ConfiguracaoController extends Controller
{

    /**
     * Lists all Configuracao entities.
     *
     * @Route("/", name="configuracao")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminCommonBundle:Configuracao')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Configuracao entity.
     *
     * @Route("/", name="configuracao_create")
     * @Method("POST")
     * @Template("AdminCommonBundle:Configuracao:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->get('admin_user.service.permissao')->apenasSuperAdmin();
        $entity = new Configuracao();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $session = $this->get('session');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.configuracao.cadastro.sucesso',0,array(),'messagesCommonBundle'));
            return $this->redirect($this->generateUrl('configuracao'));
        }
        $session->getFlashBag()->add('error', $translated->transChoice('title.configuracao.cadastro.error',0,array(),'messagesCommonBundle'));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Configuracao entity.
     *
     * @param Configuracao $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Configuracao $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new ConfiguracaoType($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')), $entity, array(
            'action' => $this->generateUrl('configuracao_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Configuracao entity.
     *
     * @Route("/new", name="configuracao_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->get('admin_user.service.permissao')->apenasSuperAdmin();
        $entity = new Configuracao();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Configuracao entity.
     *
     * @Route("/{id}/edit", name="configuracao_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Configuracao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuracao entity.');
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
    * Creates a form to edit a Configuracao entity.
    *
    * @param Configuracao $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Configuracao $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new ConfiguracaoType($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')), $entity, array(
            'action' => $this->generateUrl('configuracao_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Configuracao entity.
     *
     * @Route("/{id}", name="configuracao_update")
     * @Method("PUT")
     * @Template("AdminCommonBundle:Configuracao:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Configuracao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Configuracao entity.');
        }

        $translated = $this->get('translator');
        $session = $this->get('session');

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.configuracao.update.sucesso',0,array(),'messagesCommonBundle'));
            return $this->redirect($this->generateUrl('configuracao_edit', array('id' => $id)));
        }

        $session->getFlashBag()->add('error', $translated->transChoice('title.configuracao.update.error',0,array(),'messagesCommonBundle'));
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Configuracao entity.
     *
     * @Route("/{id}", name="configuracao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->get('admin_user.service.permissao')->apenasSuperAdmin();
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $translated = $this->get('translator');
        $session = $this->get('session');


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminCommonBundle:Configuracao')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Configuracao entity.');
            }

            $em->remove($entity);
            $em->flush();
            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.configuracao.excluir.sucesso',0,array(),'messagesCommonBundle'));
        }else{
            $session->getFlashBag()->add('error', $translated->transChoice('title.configuracao.excluir.error',0,array(),'messagesCommonBundle'));
        }

        return $this->redirect($this->generateUrl('configuracao'));
    }

    /**
     * Creates a form to delete a Configuracao entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $translated = $this->get('translator');
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configuracao_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => $translated->transChoice('txt.excluir',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-danger  btn-lg')))
            ->getForm()
        ;
    }
}
