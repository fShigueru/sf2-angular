<?php

namespace Admin\EnderecoBundle\Controller;

use Proxies\__CG__\Admin\EnderecoBundle\Entity\Estado;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\EnderecoBundle\Entity\Bairro;
use Admin\EnderecoBundle\Form\BairroType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bairro controller.
 *
 * @Route("/bairro")
 */
class BairroController extends Controller
{

    /**
     * Lists all Bairro entities.
     *
     * @Route("/", name="bairro")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminEnderecoBundle:Bairro')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Bairro entity.
     *
     * @Route("/", name="bairro_create")
     * @Method("POST")
     * @Template("AdminEnderecoBundle:Bairro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Bairro();
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

            $logger->info("Bairro - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.cadastro.bairro',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('bairro_edit', array('id' => $entity->getId())));
        } else {
            $logger->error("Bairro - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.cadastro.bairro',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Bairro entity.
     *
     * @param Bairro $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bairro $entity)
    {

        $form = $this->createForm(new BairroType(), $entity, array(
            'action' => $this->generateUrl('bairro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $this->get('translator')->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Bairro entity.
     *
     * @Route("/new", name="bairro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bairro();
        $form   = $this->createCreateForm($entity);

        $formEstado = $this->get('admin_endereco.service.estado')->retornarFormList();

        return [
            'entity'     => $entity,
            'form'       => $form->createView(),
            'formEstado' => $formEstado->createView()
        ];
    }


    /**
     * Displays a form to edit an existing Bairro entity.
     *
     * @Route("/{id}/edit", name="bairro_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Bairro')->find($id);
        $translated = $this->get('translator');
        if (!$entity) {
            throw $this->createNotFoundException($translated->transChoice('error.nao.existe.bairro',0,array(),'validacaoEnderecoBundle'));
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $estadoService = $this->get('admin_endereco.service.estado');
        $estadoForm = $estadoService->retornarFormList($entity->getCidade()->getEstado()->getSigla());
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'formEstado'  => $estadoForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Bairro entity.
    *
    * @param Bairro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bairro $entity)
    {
        $form = $this->createForm(new BairroType(), $entity, array(
            'action' => $this->generateUrl('bairro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'txt.editar', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Bairro entity.
     *
     * @Route("/{id}", name="bairro_update")
     * @Method("PUT")
     * @Template("AdminEnderecoBundle:Bairro:bloco_topo.html.twig")
     */
    public function updateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Bairro')->find($id);

        $translated = $this->get('translator');
        $session = $this->get('session');
        if (!$entity){
            throw $this->createNotFoundException($translated->transChoice('error.nao.existe.bairro',0,array(),'validacaoEnderecoBundle'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $user = $this->get('security.context');
        $logger = $this->get('monolog.logger.update');

        if ($editForm->isValid()) {
            $em->flush();

            $logger->info("Bairro - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}" );
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.update.bairro',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('bairro_edit', array('id' => $id)));
        } else {
            $logger->error("Bairro - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.update.bairro',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Bairro entity.
     *
     * @Route("/{id}", name="bairro_delete")
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
            $entity = $em->getRepository('AdminEnderecoBundle:Bairro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($translated->transChoice('error.nao.existe.bairro',0,array(),'validacaoEnderecoBundle'));
            }

            $em->remove($entity);
            $em->flush();

            $logger->error("Bairro - ID: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.delete.bairro',0,array(),'messagesEnderecoBundle'));
        }else{
            $logger->error("Bairro - ID: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.delete.bairro',0,array(),'messagesEnderecoBundle'));
        }

        return $this->redirect($this->generateUrl('bairro'));
    }

    /**
     * Creates a form to delete a Bairro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bairro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'txt.excluir', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-danger  btn-lg')))
            ->getForm()
        ;
    }

    /**
     * Ajax, buscando bairros por cidade
     *
     * @Route("/ajax/lista-bairro/{cidadeId}", name="bairro_ajax_lista")
     * @Method("GET")
     *
     * @return lista de bairros
     */
    public function ajaxBairro(Request $request, $cidadeId)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $list = [];

        $em = $this->getDoctrine()->getManager();

        $entityCidade = $em->getRepository('AdminEnderecoBundle:Cidade')->find(['id' => $cidadeId]);

        if (!$entityCidade) {
            $list[0] = 'Cidade enviada não existe';
            return $response->setContent(json_encode($list));
        }

        $entity = $em->getRepository('AdminEnderecoBundle:Bairro')->findBy(['cidade' => $entityCidade]);

        foreach($entity as $data){
            $list[$data->getId()] = $data->getNome();
        }

        return $response->setContent(json_encode($list));

    }

    /**
     * Ajax, persist bairro
     *
     * @Route("/ajax/create", name="bairro_ajax_create")
     * @Method("POST")
     *
     */
    public function ajaxCreate(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $list = [];

        try{
            $entity = $this->get("admin_endereco.service.bairro")->ajaxCreate($request);
            $list = ['status' => 1, 'message' => 'Bairro cadastrado com sucesso', 'bairro' => $entity->getNome(), 'id' => $entity->getId()];
        } catch(Exception $e){
            $list = ['status' => 0, 'message' => $e->getMessage()];
        }

        return $response->setContent(json_encode($list));
    }

}