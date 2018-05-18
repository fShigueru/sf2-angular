<?php

namespace Admin\EnderecoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\EnderecoBundle\Entity\Cidade;
use Admin\EnderecoBundle\Form\CidadeType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cidade controller.
 *
 * @Route("/cidade")
 */
class CidadeController extends Controller
{

    /**
     * Lists all Cidade entities.
     *
     * @Route("/", name="cidade")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminEnderecoBundle:Cidade')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cidade entity.
     *
     * @Route("/", name="cidade_create")
     * @Method("POST")
     * @Template("AdminEnderecoBundle:Cidade:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cidade();
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

            $logger->info("Cidade - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.cadastro.cidade',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('cidade', array('id' => $entity->getId())));
        } else {
            $logger->error("Cidade - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.cadastro.cidade',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cidade entity.
     *
     * @param Cidade $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cidade $entity)
    {

        $translated = $this->get('translator')->transChoice('txt.gravar',0,array(),'messagesCommonBundle');

        $form = $this->createForm(new CidadeType(), $entity, array(
            'action' => $this->generateUrl('cidade_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated, 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Cidade entity.
     *
     * @Route("/new", name="cidade_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cidade();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cidade entity.
     *
     * @Route("/{id}/edit", name="cidade_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Cidade')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cidade entity.');
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
    * Creates a form to edit a Cidade entity.
    *
    * @param Cidade $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cidade $entity)
    {
        $form = $this->createForm(new CidadeType(), $entity, array(
            'action' => $this->generateUrl('cidade_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'txt.editar', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Cidade entity.
     *
     * @Route("/{id}", name="cidade_update")
     * @Method("PUT")
     * @Template("AdminEnderecoBundle:Cidade:bloco_topo.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminEnderecoBundle:Cidade')->find($id);


        $translated = $this->get('translator');
        $session = $this->get('session');

        if (!$entity) {
            throw $this->createNotFoundException($translated->transChoice('error.nao.existe.cidade',0,array(),'validacaoEnderecoBundle'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $user = $this->get('security.context');
        $logger = $this->get('monolog.logger.update');

        if ($editForm->isValid()) {
            $em->flush();

            $logger->info("Cidade - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}" );
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.update.cidade',0,array(),'messagesEnderecoBundle'));
            return $this->redirect($this->generateUrl('cidade_edit', array('id' => $id)));
        } else {
            $logger->error("Cidade - Nome: {$entity->getNome()}, ID: {$entity->getId()}  - Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.update.cidade',0,array(),'messagesEnderecoBundle'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cidade entity.
     *
     * @Route("/{id}", name="cidade_delete")
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
            $entity = $em->getRepository('AdminEnderecoBundle:Cidade')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($translated->transChoice('error.nao.existe.cidade',0,array(),'validacaoEnderecoBundle'));
            }

            $em->remove($entity);
            $em->flush();

            $logger->error("Cidade - ID: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('sucesso', $translated->transChoice('sucesso.delete.cidade',0,array(),'messagesEnderecoBundle'));
        }else{
            $logger->error("Cidade - ID: {$id}  Usuário responsavel: {$user->getToken()->getUser()->getUsername()}, E-mail: {$user->getToken()->getUser()->getEmail()}, IP: {$this->get('request')->getClientIp()}");
            $session->getFlashBag()->add('error', $translated->transChoice('error.delete.cidade',0,array(),'messagesEnderecoBundle'));
        }

        return $this->redirect($this->generateUrl('cidade'));
    }

    /**
     * Creates a form to delete a Cidade entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cidade_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'txt.excluir', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-danger  btn-lg')))
            ->getForm()
        ;
    }

    /**
     * Ajax, buscando cidades por estado
     *
     * @Route("/ajax/lista-cidade/{sigla}", name="cidade_ajax_lista")
     * @Method("GET")
     *
     * @return lista de cidade
     */
    public function ajaxCidade(Request $request, $sigla)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $list = [];
        $em = $this->getDoctrine()->getManager();
        $entityEstado = $em->getRepository('AdminEnderecoBundle:Estado')->find($sigla);

        if (!$entityEstado) {
            $list[0] = 'Estado enviada não existe';
            return $response->setContent(json_encode($list));
        }

        $entity = $em->getRepository('AdminEnderecoBundle:Cidade')->findBy(['estado' => $entityEstado]);

        foreach($entity as $data){
            $list[$data->getId()] = $data->getNome();
        }

        return $response->setContent(json_encode($list));

    }
}
