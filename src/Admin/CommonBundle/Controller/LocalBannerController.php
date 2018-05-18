<?php

namespace Admin\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\CommonBundle\Entity\LocalBanner;
use Admin\CommonBundle\Form\LocalBannerType;

/**
 * LocalBanner controller.
 *
 * @Route("/localbanner")
 */
class LocalBannerController extends Controller
{

    /**
     * Lists all LocalBanner entities.
     *
     * @Route("/", name="localbanner")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminCommonBundle:LocalBanner')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new LocalBanner entity.
     *
     * @Route("/", name="localbanner_create")
     * @Method("POST")
     * @Template("AdminCommonBundle:LocalBanner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new LocalBanner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $session = $this->get('session');
        $validator = $this->get('validator');

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView()
        ];

        if ($form->isValid()) {

            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.cadastro.error',0,array(),'messagesLocalBannerCommonBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.cadastro.sucesso',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
            return $this->redirect($this->generateUrl('localbanner'));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesLocalBannerCommonBundle'));
                }
            }
        }

        return $retorno;
    }

    /**
     * Creates a form to create a LocalBanner entity.
     *
     * @param LocalBanner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(LocalBanner $entity)
    {
        $form = $this->createForm(new LocalBannerType(), $entity, array(
            'action' => $this->generateUrl('localbanner_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' =>  $this->get('translator')->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new LocalBanner entity.
     *
     * @Route("/new", name="localbanner_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LocalBanner();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LocalBanner entity.
     *
     * @Route("/{id}", name="localbanner_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:LocalBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LocalBanner entity.
     *
     * @Route("/{id}/edit", name="localbanner_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:LocalBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalBanner entity.');
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
    * Creates a form to edit a LocalBanner entity.
    *
    * @param LocalBanner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LocalBanner $entity)
    {
        $form = $this->createForm(new LocalBannerType(), $entity, array(
            'action' => $this->generateUrl('localbanner_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing LocalBanner entity.
     *
     * @Route("/{id}", name="localbanner_update")
     * @Method("PUT")
     * @Template("AdminCommonBundle:LocalBanner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:LocalBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalBanner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);


        $translated = $this->get('translator');
        $session = $this->get('session');
        $validator = $this->get('validator');

        $retorno = [
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];

        if ($editForm->isValid()) {

            try{
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.edit.error',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.edit.sucesso',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
            return $this->redirect($this->generateUrl('localbanner_edit', array('id' => $id)));

        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesLocalBannerCommonBundle'));
                }
            }
        }

        return $retorno;
    }
    /**
     * Deletes a LocalBanner entity.
     *
     * @Route("/{id}", name="localbanner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $translated = $this->get('translator');
        $session = $this->get('session');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminCommonBundle:LocalBanner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalBanner entity.');
        }

        if ($form->isValid()) {

            try{
                $em->remove($entity);
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.delete.error',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.delete.sucesso',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
        }else{
            $session->getFlashBag()->add('error', $translated->transChoice('title.delete.error',0,array('localBanner'=>$entity->getLocal()),'messagesLocalBannerCommonBundle'));
        }

        return $this->redirect($this->generateUrl('localbanner'));

    }

    /**
     * Creates a form to delete a LocalBanner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localbanner_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }
}
