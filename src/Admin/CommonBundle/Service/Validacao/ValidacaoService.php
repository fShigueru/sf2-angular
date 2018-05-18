<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 10/11/2015
 * Time: 11:32
 */

namespace Admin\CommonBundle\Service\Validacao;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class ValidacaoService
{

    private $translator;

    /**
     * ValidacaoImageService constructor.
     * @param $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     *
     * Validacao de imagem, largura e altura.
     * Nao esquecer de inserir o Assert\Image na entity
     *
     * @param $errors
     * @return string
     */
    public function validarAlturaLarguraImagem($errors)
    {
        $messages = [];
        $constraint = [];
        foreach($errors as $error){
            if(isset($error->getConstraint()->minWidth)){
                $messages[$error->getPropertyPath()] = $error->getMessage();
                foreach($error->getParameters() as $key => $value){
                    $constraint[] = $value;
                }
            }
        }
        if(key($messages) == "file") {
            if(!empty($messages)){
                return $this->translator->transChoice($messages['file'],0,array("%enviado%"=>$constraint[0],"%esperado%"=>$constraint[1]),'messagesCommonBundle');
            }
        }
        return false;
    }

    /**
     *
     * Valida��o de peso em MB
     * N�o esquecer de inserir o Assert\File na entity
     *
     * @param $errors
     * @return string
     */
    public function validarPesoImagem($errors)
    {
        $messages = [];
        $constraint = [];
        foreach($errors as $error){
            if(!isset($error->getConstraint()->minWidth)){
                $messages[$error->getPropertyPath()] = $error->getMessage();
                foreach($error->getParameters() as $key => $value){
                    $constraint[] = $value;
                }
            }
        }
        if (key($messages) == "file") {
            if (!empty($messages)) {
                return $this->translator->transChoice($messages['file'], 0, array("%enviado%" => $constraint[1]. "" . $constraint[3], "%esperado%" => $constraint[2] . "" . $constraint[3]), 'messagesCommonBundle');
            }
        }
        return false;
    }

    /**
     *
     * Valida��o, n�o enviado
     * N�o esquecer de inserir o Assert\NotBlank na entity
     *
     * @param $errors
     * @return string
     */
    public function validarIsEmpty($errors)
    {
        $messages = [];
        foreach($errors as $error){
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        if (key($messages) != "file") {
            if (!empty($messages)) {
                return $this->translator->transChoice($messages[key($messages)], 0, array(), 'messagesCommonBundle');
            }
        }
        return false;
    }
}