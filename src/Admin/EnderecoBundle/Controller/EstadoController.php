<?php

namespace Admin\EnderecoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\EnderecoBundle\Entity\Estado;
use Admin\EnderecoBundle\Form\EstadoType;

/**
 * Estado controller.
 *
 * @Route("/estado")
 */
class EstadoController extends Controller
{

    /**
     * Lists all Estado entities.
     *
     * @Route("/", name="estado")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminEnderecoBundle:Estado')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Estado entity.
     *
     * @Route("/", name="estado_create")
     * @Method("POST")
     * @Template("AdminEnderecoBundle:Estado:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Estado();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $session = $this->get('session');

        $user = $this->get('security.context');
        $logger = $this->get('monolog.logger.persist');


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $logger->info("Estado - Sigla: {$entity->getSigla()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.cadastro.estado',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('estado', array('id' => $entity->getSigla())));
        } else {
            $logger->error("Estado - Sigla: {$entity->getSigla()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.cadastro.estado',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Estado entity.
     *
     * @param Estado $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Estado $entity)
    {
        $form = $this->createForm(new EstadoType(), $entity, array(
            'action' => $this->generateUrl('estado_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' =>  $this->get('translator')->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Estado entity.
     *
     * @Route("/new", name="estado_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Estado();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Estado entity.
     *
     * @Route("/{id}/edit", name="estado_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Estado')->find($id);
        $translated = $this->get('translator');
        if (!$entity) {
            throw $this->createNotFoundException($translated->transChoice('error.nao.existe.estado',0,array(),'validacaoEnderecoBundle'));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Estado entity.
    *
    * @param Estado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Estado $entity)
    {
        $form = $this->createForm(new EstadoType(), $entity, array(
            'action' => $this->generateUrl('estado_update', array('id' => $entity->getSigla())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Estado entity.
     *
     * @Route("/{id}", name="estado_update")
     * @Method("PUT")
     * @Template("AdminEnderecoBundle:Estado:bloco_topo.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Estado')->find($id);


        $translated = $this->get('translator');
        $session = $this->get('session');
        if (!$entity) {
            throw $this->createNotFoundException($translated->transChoice('error.nao.existe.bairro',0,array(),'validacaoEnderecoBundle'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $user = $this->get('security.context');
        $logger = $this->get('monolog.logger.update');

        if ($editForm->isValid()) {
            $em->flush();

            $logger->info("Estado - Sigla: {$entity->getSigla()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}" );
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.update.estado',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('estado_edit', array('id' => $id)));
        } else {
            $logger->error("Estado - Sigla: {$entity->getSigla()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.update.estado',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Estado entity.
     *
     * @Route("/{id}", name="estado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $session = $this->get('session');

        $user = $this->get('security.context');
        $logger = $this->get('monolog.logger.delete');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminEnderecoBundle:Estado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($translated->transChoice('error.nao.existe.estado',0,array(),'validacaoEnderecoBundle'));
            }

            $em->remove($entity);
            $em->flush();

            $logger->error("Estado - Sigla: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.delete.estado',0,array(),'messagesEnderecoBundle'));
        } else {
            $logger->error("Estado - Sigla: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.delete.estado',0,array(),'messagesEnderecoBundle'));
        }

        return $this->redirect($this->generateUrl('estado'));
    }

    /**
     * Creates a form to delete a Estado entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estado_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }
}
