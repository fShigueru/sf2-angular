<?php

namespace Admin\NoticiaBundle\Controller;

use Admin\NoticiaBundle\Entity\NoticiaCategoriaTexto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\NoticiaBundle\Entity\NoticiaCategoria;
use Admin\NoticiaBundle\Form\NoticiaCategoriaType;
use Symfony\Component\HttpFoundation\Response;

/**
 * NoticiaCategoria controller.
 *
 * @Route("/noticiacategoria")
 */
class NoticiaCategoriaController extends Controller
{

    /**
     * Lists all NoticiaCategoria entities.
     *
     * @Route("/", name="noticiacategoria")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminNoticiaBundle:NoticiaCategoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new NoticiaCategoria entity.
     *
     * @Route("/", name="noticiacategoria_create")
     * @Method("POST")
     * @Template("AdminNoticiaBundle:NoticiaCategoria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NoticiaCategoria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView()
        ];

        $session = $this->get('session');
        $translated = $this->get('translator');
        $validator = $this->get('validator');

        foreach($entity->getTextos() as $value){
            $retorno = $this->get('admin_common.service.common')->verificarSlug($value,'AdminNoticiaBundle:NoticiaCategoriaTexto');
            if(!$retorno['status']){
                $session->getFlashBag()->add('error', $retorno['message']);
                return $retorno;
            }
        }

        $entity->setDtCreated(null);
        $entity->setDtUpdate(null);

        if ($form->isValid()) {

            try{
                $this->get('admin_noticia.service.categoria')->insert($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('message.error.cadastrar',0,array(),'validacaoNoticiaCategoriaBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('message.cadastro.sucesso',0,array(),'validacaoNoticiaCategoriaBundle'));
            return $this->redirect($this->generateUrl('noticiacategoria'));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'validacaoNoticiaCategoriaBundle'));
                }
            }
        }

        return $retorno;
    }

    /**
     * Creates a form to create a NoticiaCategoria entity.
     *
     * @param NoticiaCategoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NoticiaCategoria $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new NoticiaCategoriaType(), $entity, array(
            'action' => $this->generateUrl('noticiacategoria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg', 'ng-disabled' => 'admin_noticiabundle_noticiacategoria.$invalid')));

        return $form;
    }

    /**
     * Displays a form to create a new NoticiaCategoria entity.
     *
     * @Route("/new", name="noticiacategoria_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new NoticiaCategoria();
        $textoPt = new NoticiaCategoriaTexto();
        $idioma = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');
        $textoPt->setIdioma($idioma);
        $entity->addTextos($textoPt);

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NoticiaCategoria entity.
     *
     * @Route("/{id}", name="noticiacategoria_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminNoticiaBundle:NoticiaCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NoticiaCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NoticiaCategoria entity.
     *
     * @Route("/{id}/edit", name="noticiacategoria_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminNoticiaBundle:NoticiaCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NoticiaCategoria entity.');
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
    * Creates a form to edit a NoticiaCategoria entity.
    *
    * @param NoticiaCategoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NoticiaCategoria $entity)
    {
        $form = $this->createForm(new NoticiaCategoriaType(), $entity, array(
            'action' => $this->generateUrl('noticiacategoria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NoticiaCategoria entity.
     *
     * @Route("/{id}", name="noticiacategoria_update")
     * @Method("PUT")
     * @Template("AdminNoticiaBundle:NoticiaCategoria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminNoticiaBundle:NoticiaCategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NoticiaCategoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('noticiacategoria_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NoticiaCategoria entity.
     *
     * @Route("/{id}", name="noticiacategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminNoticiaBundle:NoticiaCategoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NoticiaCategoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('noticiacategoria'));
    }

    /**
     * Creates a form to delete a NoticiaCategoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('noticiacategoria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Verificar se o slug já esta sendo usado
     *
     * @Route("/ajax/slug", name="verificar-slug")
     * @Method("POST")
     */
    public function slug(Request $request)
    {
        $retorno = [];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());
        $entity = new NoticiaCategoriaTexto();
        $entity->setSlug($post->slug);

        $retorno = $this->get('admin_common.service.common')->verificarSlug($entity,'AdminNoticiaBundle:NoticiaCategoriaTexto');

        return $response->setContent(json_encode($retorno));
    }
}
