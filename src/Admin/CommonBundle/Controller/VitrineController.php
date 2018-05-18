<?php

namespace Admin\CommonBundle\Controller;

use Admin\ImageBundle\Entity\Image;
use Admin\ImageBundle\Entity\ImageProporcao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\CommonBundle\Entity\Vitrine;
use Admin\CommonBundle\Form\VitrineType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Vitrine controller.
 *
 * @Route("/vitrine")
 */
class VitrineController extends Controller
{

    private $path = "vitrine";

    /**
     * Lists all Vitrine entities.
     *
     * @Route("/", name="vitrine")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminCommonBundle:Vitrine')->findAllByOrder();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Vitrine entity.
     *
     * @Route("/", name="vitrine_create")
     * @Method("POST")
     * @Template("AdminCommonBundle:Vitrine:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vitrine();
        $entity->setDtCreated(null);
        $entity->setDtUpdate(null);
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setThumbH("100");
        $fotoProporcoes->setThumbW("100");
        $foto->addProporcoes($fotoProporcoes);
        $entity->setImage($foto);

        $form = $this->createCreateForm($entity);

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        if ($request->get("ifFiltroData") == 0) {
            $entity->setDtPublicacao(null);
            $entity->setDtExpiracao(null);
        }

        if ($entity->getStatus() == null)
             $entity->setStatus(1);

        if ($entity->getTarget() == null)
            $entity->setTarget('_blank');

        $form->handleRequest($request);

        if ($entity->getOrdem() == null)
            $entity->setOrdem(0);

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView()
        ];

        if ($form->isValid()) {
            /*
           * Upload da imagem enviada
           */
            if ($entity->getImage()->getFile() != null) {
                $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
            }
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.vitrine.cadastro.error',0,array(),'messagesVitrineCommonBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.vitrine.cadastro.sucesso',0,array(),'messagesVitrineCommonBundle'));
            return $this->redirect($this->generateUrl('vitrine'));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesVitrineCommonBundle'));
                }
            }
        }
    }

    /**
     * Creates a form to create a Vitrine entity.
     *
     * @param Vitrine $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vitrine $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new VitrineType(), $entity, array(
            'action' => $this->generateUrl('vitrine_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Vitrine entity.
     *
     * @Route("/new", name="vitrine_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vitrine();
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setCropSizeW("900");
        $fotoProporcoes->setCropSizeH("399");
        $foto->addProporcoes($fotoProporcoes);
        $entity->setImage($foto);

        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Vitrine entity.
     *
     * @Route("/{id}/edit", name="vitrine_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Vitrine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vitrine entity.');
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
    * Creates a form to edit a Vitrine entity.
    *
    * @param Vitrine $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vitrine $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new VitrineType(), $entity, array(
            'action' => $this->generateUrl('vitrine_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Vitrine entity.
     *
     * @Route("/{id}", name="vitrine_update")
     * @Method("PUT")
     * @Template("AdminCommonBundle:Vitrine:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Vitrine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vitrine entity.');
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

        if($request->get("ifFiltroData") == 0){
            $entity->setDtPublicacao(null);
            $entity->setDtExpiracao(null);
        }

        $entity->setDtUpdate(null);

        if ($editForm->isValid()) {

            /*
            * Upload da imagem enviada
            */
            if ($entity->getImage()->getFile() != null) {
                $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
            }

            try{
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('message.alterado.error',0,array(),'validacaoPaginaBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.vitrine.update.sucesso',0,array(),'messagesVitrineCommonBundle'));
            return $this->redirect($this->generateUrl('vitrine_edit', array('id' => $id)));
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
     * Deletes a Vitrine entity.
     *
     * @Route("/{id}", name="vitrine_delete")
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
            $entity = $em->getRepository('AdminCommonBundle:Vitrine')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vitrine entity.');
            }

            /* Se existir imagem na aws, remove */
            if($entity->getImage()->getImage() != null){
                $this->get('admin_image.service.image')->remover($entity,$this->path);
            }

            try{
                $em->remove($entity);
                $em->flush();
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.vitrine.excluir.error',0,array(),'messagesVitrineCommonBundle'));
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.vitrine.excluir.sucesso',0,array(),'messagesVitrineCommonBundle'));
        }else{
            $session->getFlashBag()->add('error', $translated->transChoice('title.vitrine.excluir.error',0,array(),'messagesVitrineCommonBundle'));
        }

        return $this->redirect($this->generateUrl('vitrine'));
    }

    /**
     * Creates a form to delete a Vitrine entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $translated = $this->get('translator');
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vitrine_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }
}
