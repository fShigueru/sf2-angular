<?php

namespace Admin\EnderecoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\EnderecoBundle\Entity\Logradouro;
use Admin\EnderecoBundle\Form\LogradouroType;

/**
 * Logradouro controller.
 *
 * @Route("/logradouro")
 */
class LogradouroController extends Controller
{

    /**
     * Lists all Logradouro entities.
     *
     * @Route("/", name="logradouro")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminEnderecoBundle:Logradouro')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Logradouro entity.
     *
     * @Route("/", name="logradouro_create")
     * @Method("POST")
     * @Template("AdminEnderecoBundle:Logradouro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Logradouro();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('logradouro_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Logradouro entity.
     *
     * @param Logradouro $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Logradouro $entity)
    {
        $form = $this->createForm(new LogradouroType(), $entity, array(
            'action' => $this->generateUrl('logradouro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Logradouro entity.
     *
     * @Route("/new", name="logradouro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Logradouro();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Logradouro entity.
     *
     * @Route("/{id}", name="logradouro_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Logradouro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logradouro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Logradouro entity.
     *
     * @Route("/{id}/edit", name="logradouro_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Logradouro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logradouro entity.');
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
    * Creates a form to edit a Logradouro entity.
    *
    * @param Logradouro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Logradouro $entity)
    {
        $form = $this->createForm(new LogradouroType(), $entity, array(
            'action' => $this->generateUrl('logradouro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Logradouro entity.
     *
     * @Route("/{id}", name="logradouro_update")
     * @Method("PUT")
     * @Template("AdminEnderecoBundle:Logradouro:bloco_topo.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Logradouro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logradouro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('logradouro_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Logradouro entity.
     *
     * @Route("/{id}", name="logradouro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminEnderecoBundle:Logradouro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Logradouro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('logradouro'));
    }

    /**
     * Creates a form to delete a Logradouro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logradouro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
