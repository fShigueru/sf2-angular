<?php

namespace Admin\CommonBundle\Controller;

use Admin\ImageBundle\Entity\Image;
use Admin\ImageBundle\Entity\ImageProporcao;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\CommonBundle\Entity\Banner;
use Admin\CommonBundle\Form\BannerType;

/**
 * Banner controller.
 *
 * @Route("/banner")
 */
class BannerController extends Controller
{
    private $path = "banner";

    /**
     * Lists all Banner entities.
     *
     * @Route("/", name="banner")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminCommonBundle:Banner')->findAll();

        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerNaoUsados();
        $habilitado = true;
        if(empty($ids))
            $habilitado = false;

        return array(
            'entities' => $entities,
            'habilitado' => $habilitado
        );
    }
    /**
     * Creates a new Banner entity.
     *
     * @Route("/", name="banner_create")
     * @Method("POST")
     * @Template("AdminCommonBundle:Banner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Banner();
        $entity->setDtCreated(null);
        $entity->setDtUpdate(null);
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $fotoProporcoes->setThumbH("100");
        $fotoProporcoes->setThumbW("100");
        $foto->addProporcoes($fotoProporcoes);
        $entity->setImage($foto);

        $em = $this->getDoctrine()->getManager();
        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerUsados();

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        $form = $this->createCreateForm($entity,$ids);

        if ($entity->getStatus() == null)
            $entity->setStatus(1);

        if ($entity->getTarget() == null)
            $entity->setTarget('_blank');

        if($entity->getDtPublicacao() == null)
            $entity->setDtPublicacao(null);

        if($entity->getDtExpiracao() == null)
            $entity->setDtExpiracao(null);

        if ($entity->getDtCreated() > $entity->getDtPublicacao())
            $entity->setDtPublicacao($entity->getDtCreated());

        $form->handleRequest($request);

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView()
        ];

        if ($form->isValid()) {

            $entity->getImage()->getProporcoes()[0]->setCropSizeW($entity->getLocal()->getWidth());
            $entity->getImage()->getProporcoes()[0]->setCropSizeH($entity->getLocal()->getHeight());

            /*
            * Upload da imagem enviada
            */
            if ($entity->getImage()->getFile() != null) {
                $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
            }else{
                $session->getFlashBag()->add('error', $translated->transChoice('title.file.empty',0,array(),'messagesImageBundle'));
                return $retorno;
            }

            try{
                $this->get('admin_common.service.banner')->insert($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.cadastro.error',0,array(),'messagesBannerCommonBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.cadastro.sucesso',0,array('title'=>$entity->getTitulo()),'messagesBannerCommonBundle'));
            return $this->redirect($this->generateUrl('banner'));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesBannerCommonBundle'));
                }
            }else{
                $session->getFlashBag()->add('error', $translated->transChoice('title.cadastro.error',0,array(),'messagesBannerCommonBundle'));
            }
        }

        return $retorno;
    }

    /**
     * Creates a form to create a Banner entity.
     *
     * @param Banner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Banner $entity,$localDisponivel)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new BannerType(), $entity, array(
            'action' => $this->generateUrl('banner_create'),
            'method' => 'POST',
            'local' => $localDisponivel
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Banner entity.
     *
     * @Route("/new", name="banner_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {

        $em = $this->getDoctrine()->getManager();
        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerNaoUsados();
        if(empty($ids)){
            $translated = $this->get('translator');
            $session = $this->get('session');
            $session->getFlashBag()->add('error', $translated->transChoice('title.message.localbanner.nao.existe',0,array(),'messagesLocalBannerCommonBundle'));
            return $this->redirect($this->generateUrl('banner'));
        }

        $entity = new Banner();
        $foto = new Image();
        $fotoProporcoes = new ImageProporcao();
        $foto->addProporcoes($fotoProporcoes);
        $entity->setImage($foto);
        $entity->setDtPublicacao(null);
        $entity->setDtExpiracao(null);

        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerUsados();
        $form = $this->createCreateForm($entity,$ids);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Banner entity.
     *
     * @Route("/{id}", name="banner_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Banner entity.
     *
     * @Route("/{id}/edit", name="banner_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Banner')->find($id);

        if (!$entity)
            throw $this->createNotFoundException('Unable to find Banner entity.');

        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerUsadosNotInId($entity);
        $editForm = $this->createEditForm($entity,$ids);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
    * Creates a form to edit a Banner entity.
    *
    * @param Banner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Banner $entity,$localDisponivel)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new BannerType(), $entity, array(
            'action' => $this->generateUrl('banner_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'local' => $localDisponivel
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Banner entity.
     *
     * @Route("/{id}", name="banner_update")
     * @Method("PUT")
     * @Template("AdminCommonBundle:Banner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminCommonBundle:Banner')->find($id);

        if (!$entity)
            throw $this->createNotFoundException('Unable to find Banner entity.');

        $deleteForm = $this->createDeleteForm($id);
        $ids = $em->getRepository('AdminCommonBundle:Banner')->getLocalBannerUsadosNotInId($entity);
        $editForm = $this->createEditForm($entity,$ids);
        $editForm->handleRequest($request);

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        $retorno = [
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];

        $entity->setDtUpdate(null);

        if ($editForm->isValid()) {

            /*
            * Upload da imagem enviada
            */
            if ($entity->getImage()->getFile() != null) {
                $entity->getImage()->setImage($this->get('admin_image.service.image')->upload($entity,$this->path));
            }

            try{
                $this->get('admin_common.service.banner')->update($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.edit.error',0,array('title'=>$entity->getTitulo()),'messagesBannerCommonBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.cadastro.sucesso',0,array('title'=>$entity->getTitulo()),'messagesBannerCommonBundle'));
            return $this->redirect($this->generateUrl('banner_edit', array('id' => $id)));
        }else{
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesBannerCommonBundle'));
                }
            }
        }

        return $retorno;
    }
    /**
     * Deletes a Banner entity.
     *
     * @Route("/{id}", name="banner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $translated = $this->get('translator');
        $session = $this->get('session');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminCommonBundle:Banner')->find($id);

        if ($form->isValid()) {

            if (!$entity)
                throw $this->createNotFoundException('Unable to find Banner entity.');

            /* Se existir imagem na aws, remove */
            if($entity->getImage()->getImage() != null){
                $this->get('admin_image.service.image')->remover($entity,$this->path);
            }

            try{
                $this->get('admin_common.service.banner')->delete($entity);
            } catch(\Exception $e) {
                $session->getFlashBag()->add('error', $translated->transChoice('title.delete.error',0,array('title'=>$entity->getLocal()),'messagesBannerCommonBundle'));
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.delete.sucesso',0,array('title'=>$entity->getLocal()),'messagesBannerCommonBundle'));
        }else{
            $session->getFlashBag()->add('error', $translated->transChoice('title.delete.error',0,array('title'=>$entity->getLocal()),'messagesBannerCommonBundle'));
        }

        return $this->redirect($this->generateUrl('banner'));
    }

    /**
     * Creates a form to delete a Banner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $translated = $this->get('translator');
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banner_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }
}
