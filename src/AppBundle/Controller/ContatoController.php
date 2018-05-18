<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contato;
use AppBundle\Form\ContatoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContatoController extends Controller
{

    /**
     * @Route("/contato", name="app_contato")
     * @Method("GET")
     * @Template(vars={"controller" = "Contato"})
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Envia email
     *
     * @Route("/ajax/contato", name="send-email-contato")
     * @Method("POST")
     */
    public function contatoAjax(Request $request)
    {
        $retorno = [];
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $request->request->get('foo', 'baz');
        $entity = new Contato();
        $post = json_decode($request->getContent());
        $entity->setAssunto("Fshigueru - Contato de orçamento");
        $form = $this->createForm(new ContatoType(), $entity, []);

        $contato['nome'] = $post->nome;
        $contato['email'] = $post->email;
        $contato['telefone'] = $post->telefone;
        $contato['mensagem'] = $post->mensagem;
        $request->request->set('appbundle_contatotype', $contato);
        $form->handleRequest($request);

        $translated = $this->get('translator');
        $retorno['status'] = 0;
        $retorno['message'] = $translated->transChoice('label.contato.error',0,array(),'messages_error');

        if($form->isValid()){
            $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
            $recipient = $this->container->getParameter('email_image_url');
            $entity->setImage($baseurl.$recipient.'/home/logo.png');

            $service = $this->get('app.service.contato');
            $email = $this->getParameter('email');
            $emailCc = $this->getParameter('email_cc');
            if($this->get('mailer')->send($service->enviarContato($entity,$email,$email,$emailCc))){
                //if($this->get('mailer')->send($service->enviarContato($entity,$entity->getEmail(),$email,$emailCc))){
                    $retorno['status'] = 1;
                    $retorno['message'] = $translated->transChoice('label.contato.sucesso',0,array(),'messages');
                //}
            }
        }else{
            $validator = $this->get('validator');
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                foreach($errors as $error){
                    dump($error->getMessage());
                }
            }
        }
        return $response->setContent(json_encode($retorno));
    }
}