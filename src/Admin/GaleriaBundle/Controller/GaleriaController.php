<?php

namespace Admin\GaleriaBundle\Controller;

use Admin\CommonBundle\Entity\Idioma;
use Admin\GaleriaBundle\Entity\GaleriaProporcao;
use Admin\GaleriaBundle\Entity\ImageGaleria;
use Admin\GaleriaBundle\Entity\ImageGaleriaTexto;
use Admin\GaleriaBundle\Form\GaleriaIdEntityType;
use Presta\SitemapBundle\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\GaleriaBundle\Entity\Galeria;
use Admin\GaleriaBundle\Form\GaleriaType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Galeria controller.
 *
 * @Route("/galeria")
 */
class GaleriaController extends Controller
{
    private $path = "galeria";

    /**
     * Lists all Galeria entities.
     *
     * @Route("/", name="galeria")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminGaleriaBundle:Galeria')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Galeria entity.
     *
     * @Route("/", name="galeria_create")
     * @Method("POST")
     * @Template("AdminGaleriaBundle:Galeria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Galeria();
        $em = $this->getDoctrine()->getManager();
        $entity->setDtCreated(null);
        $entity->setDtUpdate(null);
        $entity->setIdEntity($request->request->get('admin_galeriabundle_idEntity')['idEntity']);
        for($i=1;$i<=$request->request->get('qtde');$i++){
            $image = new ImageGaleria();
            $imageTexto = new ImageGaleriaTexto();
            $proporcoes = new GaleriaProporcao();
            $proporcoes->setThumbW('181');
            $proporcoes->setThumbH('129');
            $image->setProporcoes($proporcoes);
            $image->addTextos($imageTexto);
            $entity->addImage($image);
        }
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        foreach($entity->getImage() as $key => $value){
            foreach($value->getTextos() as $texto){
                $idioma = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');
                $texto->setIdioma($idioma);
            }
        }

        if($entity->getDtCreated() > $entity->getDtPublicacao()){
            $entity->setDtPublicacao($entity->getDtCreated());
        }

        $formIdEntity  = $this->createForm(new GaleriaIdEntityType(),null,['iniciar'=>[],'default'=>null]);
        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView(),
            'formIdEntity' => $formIdEntity->createView(),
            'qtde' => $request->request->get('qtde')
        ];

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        if ($form->isValid()) {

            try{
                $this->get('admin_galeria.service.galeria')->insert($entity);

                $this->get('admin_image.service.image')->multUpload($entity,$this->path);

                $this->get('admin_galeria.service.galeria')->update($entity);
            }catch(Exception $e){
                $session->getFlashBag()->add('error', $translated->transChoice('title.new.error',0,array(),'messagesGaleriaBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.new.sucesso',0,array('title'=>$entity->getTitulo()),'messagesGaleriaBundle'));
            return $this->redirect($this->generateUrl('galeria'));
        }else{
            $errors = $validator->validate($entity);
            $errorsImage = $validator->validate($entity->getImage());
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesGaleriaBundle'));
                }
            }
            elseif (count($errorsImage) > 0 ){
                foreach($errorsImage as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesGaleriaBundle'));
                }
            }
            else{
                $session->getFlashBag()->add('error', $translated->transChoice('title.new.error',0,array(),'messagesGaleriaBundle'));
            }
        }

        return $retorno;
    }

    /**
     * Creates a form to create a Galeria entity.
     *
     * @param Galeria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Galeria $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new GaleriaType(), $entity, array(
            'action' => $this->generateUrl('galeria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.gravar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }

    /**
     * Displays a form to create a new Galeria entity.
     *
     * @Route("/new/{qtde}",requirements={"qtde"="\d+"}, defaults={"qtde"=1}, name="galeria_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($qtde)
    {
        $entity = new Galeria();
        $entity->setCropSizeH('250');
        $entity->setCropSizeW('250');
        $entity->setDtPublicacao(null);
        $entity->setDtExpiracao(null);
        for($i=1;$i<=$qtde;$i++){
            $image = new ImageGaleria();
            $imageTexto = new ImageGaleriaTexto();
            $proporcoes = new GaleriaProporcao();
            $image->setProporcoes($proporcoes);
            $em = $this->getDoctrine()->getManager();
            $idioma = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');
            $imageTexto->setIdioma($idioma);
            $image->addTextos($imageTexto);
            $entity->addImage($image);
        }

        $form = $this->createCreateForm($entity);

        $formIdEntity  = $this->createForm(new GaleriaIdEntityType(),null,['iniciar'=>[],'default'=>null]);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'qtde'   => $qtde,
            'formIdEntity' => $formIdEntity->createView()
        );
    }

    /**
     * Finds and displays a Galeria entity.
     *
     * @Route("/{id}", name="galeria_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminGaleriaBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Galeria entity.
     *
     * @Route("/{id}/edit/{qtde}",requirements={"qtde"="\d+"}, defaults={"qtde"=0}, name="galeria_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id,$qtde)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminGaleriaBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $qtdeCadastrada = count($entity->getImage());
        $qtdeTotal = ($qtde+count($entity->getImage()));

        for($i=1;$i<=$qtde;$i++){
            $image = new ImageGaleria();
            $imageTexto = new ImageGaleriaTexto();
            $proporcoes = new GaleriaProporcao();
            $image->setProporcoes($proporcoes);
            $em = $this->getDoctrine()->getManager();
            $idioma = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');
            $imageTexto->setIdioma($idioma);
            $image->addTextos($imageTexto);
            $entity->addImage($image);
        }

        $form = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $initIdEntity = [];

        try{
            $initIdEntity = $this->get('admin_galeria.service.galeria')->formatOptions($entity->getEntity());
        }catch(\Exception $e){
        }

        $formIdEntity  = $this->createForm(new GaleriaIdEntityType(),null,['iniciar' => $initIdEntity,'default'=>$entity->getIdEntity()]);

        return array(
            'entity'      => $entity,
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'qtde'   => $qtde,
            'qtdeTotal' => $qtdeTotal,
            'qtdeCadastrada' => $qtdeCadastrada,
            'formIdEntity' => $formIdEntity->createView()
        );
    }

    /**
    * Creates a form to edit a Galeria entity.
    *
    * @param Galeria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Galeria $entity)
    {
        $translated = $this->get('translator');
        $form = $this->createForm(new GaleriaType(), $entity, array(
            'action' => $this->generateUrl('galeria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => $translated->transChoice('txt.editar',0,array(),'messagesCommonBundle'), 'attr' => array('class' => 'btn btn-primary  btn-lg')));

        return $form;
    }
    /**
     * Edits an existing Galeria entity.
     *
     * @Route("/{id}", name="galeria_update")
     * @Method("PUT")
     * @Template("AdminGaleriaBundle:Galeria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminGaleriaBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        $entity->setIdEntity($request->request->get('admin_galeriabundle_idEntity')['idEntity']);

        foreach($entity->getImage() as $value){
            if($value->getImage() == null){
                $value->setGaleria($entity);
                foreach($value->getTextos() as $texto){

                    $idioma = $em->getRepository('AdminCommonBundle:Idioma')->find('pt');
                    $texto->setIdioma($idioma);
                    $texto->setImageGaleria($value);
                }
                $value->getProporcoes()->setThumbW('181');
                $value->getProporcoes()->setThumbH('129');
            }
        }

        $initIdEntity = [];
        try{
            $initIdEntity = $this->get('admin_galeria.service.galeria')->formatOptions($entity->getEntity());
        }catch(\Exception $e){
        }

        $formIdEntity  = $this->createForm(new GaleriaIdEntityType(),null,['iniciar' => $initIdEntity,'default'=>$entity->getIdEntity()]);

        $retorno = [
            'entity' => $entity,
            'form'   => $form->createView(),
            'formIdEntity' => $formIdEntity->createView(),
            'qtde' => 0,
            'qtdeTotal' => count($entity->getImage()),
            'qtdeCadastrada' => count($entity->getImage()),
            'delete_form' => $deleteForm->createView()
        ];

        $translated = $this->get('translator');
        $validator = $this->get('validator');
        $session = $this->get('session');

        if ($form->isValid()) {
            try{
                $this->get('admin_image.service.image')->multUpload($entity,$this->path);

                $this->get('admin_galeria.service.galeria')->update($entity);
            }catch(Exception $e){
                $session->getFlashBag()->add('error', $translated->transChoice('title.edit.error',0,array(),'messagesGaleriaBundle'));
                return $retorno;
            }

            $session->getFlashBag()->add('sucesso', $translated->transChoice('title.edit.sucesso',0,array('title'=>$entity->getTitulo()),'messagesGaleriaBundle'));
            return $this->redirect($this->generateUrl('galeria_edit', array('id' => $id)));
        }else{
            $errors = $validator->validate($entity);
            $errorsImage = $validator->validate($entity->getImage());
            if (count($errors) > 0) {
                foreach($errors as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesGaleriaBundle'));
                }
            }
            elseif (count($errorsImage) > 0 ){
                foreach($errorsImage as $error){
                    $session->getFlashBag()->add('error', $translated->transChoice($error->getMessage(),0,array(),'messagesGaleriaBundle'));
                }
            }
            else{
                $session->getFlashBag()->add('error', $translated->transChoice('title.new.error',0,array(),'messagesGaleriaBundle'));
            }
        }

        return $retorno;
    }
    /**
     * Deletes a Galeria entity.
     *
     * @Route("/{id}", name="galeria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminGaleriaBundle:Galeria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Galeria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('galeria'));
    }

    /**
     * Creates a form to delete a Galeria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('galeria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'title.sim', 'translation_domain' => 'messagesCommonBundle', 'attr' => array('class' => 'btn btn-success btn-lg bt-delete-foto')))
            ->getForm()
        ;
    }

    /**
     * Buscar registro por entity
     *
     * @Route("/ajax/idEntity", name="busca-por-entity")
     * @Method("POST")
     */
    public function buscaPorEntity(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $array = $this->get('admin_galeria.service.galeria')->formatOptions($post->entity);
        $retorno['status'] = true;
        $retorno['dados'] = $array;

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Buscar registro por entity
     *
     * @Route("/ajax/update-image", name="update-image")
     * @Method("POST")
     */
    public function updateImageGaleria(Request $request)
    {
        $retorno = ['status' => false];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminGaleriaBundle:ImageGaleria')->find($post->id);

        $entity->getProporcoes()->setCropStartLeft($post->cropStartLeft);
        $entity->getProporcoes()->setCropStartTop($post->cropStartTop);
        $entity->getProporcoes()->setScale($post->scale);

        foreach($entity->getTextos() as $texto){
            $texto->setTitulo($post->titulo);
            $texto->setSubtitulo($post->subtitulo);
            $texto->setDescricao($post->descricao);
        }

        try{
            $this->get('admin_galeria.service.galeria')->updateImageGaleria($entity);
            $retorno['status'] = true;
            $retorno['message'] = "Dados da imagem atualizados com sucesso!";
        }catch(Exception $e){
            $retorno['message'] = "Erro ao atualizar os dados da imagem - {$e->getMessage()}";
        }

        return $response->setContent(json_encode($retorno));
    }

    /**
     * Buscar registro por entity
     *
     * @Route("/ajax/delete/image", name="delete-galeria-image")
     * @Method("POST")
     */
    public function deleteGaleriaImage(Request $request)
    {
        $retorno = [];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $post = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminGaleriaBundle:ImageGaleria')->find($post->id);

        if (!$entity) {
            $retorno['status'] = false;
            $retorno['message'] = 'Erro ao buscar a imagem, por favor, comunique ao desenvolvedor!';
        }else{
            $retorno = $this->get('admin_galeria.service.galeria')->deleteImage($entity);
            if($retorno['status']){
                $retorno['message'] = 'Imagem excluida com sucesso!';
            }
        }

        return $response->setContent(json_encode($retorno));
    }
}
