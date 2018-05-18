<?php

namespace Admin\UserBundle\Controller;

use Admin\UserBundle\Entity\User;
use Admin\UserBundle\Form\ProfileFormType;
use Admin\UserBundle\Form\UserRoleType;
use Presta\SitemapBundle\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * User controller.
 *
 * @Route("/users")
 */
class UserController extends Controller
{

    /**
     * List user
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if (!$this->verificarAuth(true,['ROLE_USER_ADMIN']))
            return $this->redirect($this->generateUrl('dashboard'));

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        foreach($users as $key => $user){
            if(in_array('ROLE_ADMIN', $user->getRoles())){
                unset($users[$key]);
            }
        }

        return array(
            'entities' => $users,
        );
    }


    /**
     * Finds and displays User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        if (!$this->verificarAuth(true,['ROLE_USER_ADMIN']))
            return $this->redirect($this->generateUrl('dashboard'));

        $userManager = $this->get('fos_user.user_manager');
        $entity = $userManager->findUserBy(['id' => $id]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $options = [
            'id' => $entity->getId(),
            'selectdRole' => $entity->getRoles()
        ];
        $formRole =  $this->createForm(new UserRoleType(),null,$options);

        return array(
            'entity' => $entity,
            'formRole' => $formRole->createView()
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        if (!$this->verificarAuth(true,['ROLE_USER_ADMIN'])) {
            return $this->redirect($this->generateUrl('dashboard'));
        }

        $userManager = $this->get('fos_user.user_manager');
        $entity = $userManager->findUserBy(['id' => $id]);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vitrine entity.');
        }

        $formNew = $this->container->get('form.factory');
        $form = $formNew->create(new ProfileFormType(), $entity)->createView();

        return array(
            'entity' => $entity,
            'form'   =>  $form
        );
    }

    /**
     * Creates a form to edit a Vitrine entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new ProfileFormType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     * @Template("AdminUserBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {

    }

    /**
     * Ajax, Altera o status do usuário
     *
     * @Route("/ajax/alterar-status", name="user-alterar-status")
     * @Method("POST")
     */
    public function alterarStatus(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (!$this->verificarAuth(false,['ROLE_USER_ADMIN'])) {
            $retorno['message'] = 'Você não está autorizado a realizar esse procedimento';
            return $response->setContent(json_encode($retorno));
        }

        $post = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $entity = $userManager->findUserBy(['id' => $post->id]);

        if (!$entity) {
            $retorno['message'] = 'Esse usuário não existe.';
            return $response->setContent(json_encode($retorno));
        }

        if(in_array('ROLE_ADMIN', $entity->getRoles())){
            $retorno['message'] = 'Você não pode alterar o status de um Super Admin';
            return $response->setContent(json_encode($retorno));
        }

        if($entity->isEnabled()){
            $entity->setEnabled(false);
        }else{
            $entity->setEnabled(true);
        }

        $translated = $this->get('translator');

        try{
            $userManager->updateUser($entity);
            $message = "";
            $statusButton = [];
            if($entity->isEnabled()){
                $message = "Usuário está habilitado a usar o sistema.";
                $statusButton['addClassStatus'] = 'btn-success';
                $statusButton['removeClassStatus'] = 'btn-danger';
                $statusButton['message'] = $translated->transChoice('title.ativo',0,array(),'messagesCommonBundle');
            }else{
                $message = "Usuário está desabilitado";
                $statusButton['addClassStatus'] = 'btn-danger';
                $statusButton['removeClassStatus'] = 'btn-success';
                $statusButton['message'] = $translated->transChoice('title.inativo',0,array(),'messagesCommonBundle');
            }
            $retorno['message'] = $message;
            $retorno['status'] = true;
            $retorno['statusButton'] = $statusButton;
        }catch(Exception $e){
            $retorno['message'] =  'Erro ao alterar o status do usuário';
        }

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Ajax, Altera o role do usuário
     *
     * @Route("/ajax/alterar-role", name="user-alterar-role")
     * @Method("POST")
     */
    public function alterarRole(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (!$this->verificarAuth(false,['ROLE_USER_ADMIN'])) {
            $retorno['message'] = 'Você não está autorizado a realizar esse procedimento';
            return $response->setContent(json_encode($retorno));
        }

        $post = json_decode($request->getContent());

        $userManager = $this->get('fos_user.user_manager');
        $entity = $userManager->findUserBy(['id' => $post->id]);

        if (!$entity) {
            $retorno['message'] = 'Esse usuário não existe.';
            return $response->setContent(json_encode($retorno));
        }

        if(in_array('ROLE_ADMIN', $entity->getRoles())){
            $retorno['message'] = 'Você não pode alterar o nível de acesso de um Super Admin';
            return $response->setContent(json_encode($retorno));
        }

        $translated = $this->get('translator');

        try{
            $entity->setRoles($post->roles);
            $userManager->updateUser($entity);
            $retorno['message'] = $translated->transChoice('title.message.update.role.sucesso',0,array(),'messagesUserBundle');
            $retorno['status'] = true;
        }catch(Exception $e){
            $retorno['message'] = $translated->transChoice('title.message.update.role.error',0,array(),'messagesUserBundle');
        }

        return $response->setContent(json_encode($retorno));
    }

    private function verificarAuth($redirect = true,$roles = null)
    {
        if (!$this->get('admin_user.auth')->verificarAutorizacao($roles)) {
            $translated = $this->get('translator');
            $session = $this->get('session');
            $logger = $this->get('monolog.logger.user');
            $userDefault = $this->get('security.token_storage');
            $request = $this->get('request');
            $logger->info("O Usuário : {$userDefault->getToken()->getUser()->getUsername()}, E-mail: {$userDefault->getToken()->getUser()->getEmail()}, IP: {$request->getClientIp()}, não autorizado acessou a rota '{$request->getRequestUri()}' - '{$request->get('_route')}'" );
            if($redirect)
                $session->getFlashBag()->add('sucesso', $translated->transChoice('title.auth.nao.autorizado', 0, array('rota'=>'Usuários'), 'messagesCommonBundle'));
            return false;
        }
        return true;
    }
}
