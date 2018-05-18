<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/04/2016
 * Time: 17:45
 */

namespace Admin\CommonBundle\Service\Validacao;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

interface IValidacaoService
{

    /**
     * ValidacaoImageService constructor.
     * @param $translator
     */
    public function __construct(Translator $translator);

    /**
     *
     * Validacao de imagem, largura e altura.
     * Nao esquecer de inserir o Assert\Image na entity
     *
     * @param $errors
     * @return string
     */
    public function validarAlturaLarguraImagem($errors);

    /**
     *
     * Valida��o de peso em MB
     * N�o esquecer de inserir o Assert\File na entity
     *
     * @param $errors
     * @return string
     */
    public function validarPesoImagem($errors);

    /**
     *
     * Valida��o, n�o enviado
     * N�o esquecer de inserir o Assert\NotBlank na entity
     *
     * @param $errors
     * @return string
     */
    public function validarIsEmpty($errors);

}