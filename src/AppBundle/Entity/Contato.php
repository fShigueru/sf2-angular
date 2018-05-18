<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 18/07/2015
 * Time: 11:09
 */

namespace AppBundle\Entity;

use AppBundle\Entity\ContatoInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Contato implements ContatoInterface {

    /**
     *@var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *@var string
     *
     * @ORM\Column(name="nome", type="string" ,length=255)
     * @Assert\NotBlank(
     *     message = "message.contato.error.embranco.nome"
     * )
     *
     */
    private $nome;

    /**
     *@var string
     *
     * @ORM\Column(name="mensagem", type="text")
     * @Assert\NotBlank(
     *     message = "message.contato.error.embranco.mensagem"
     * )
     */
    private $mensagem;

    /**
     *@var string
     *
     * @ORM\Column(name="email", type="text")
     * @Assert\NotBlank(
     *     message = "message.contato.error.embranco.email"
     * )
     */
    private $email;

    /**
     *@var string
     *
     * @ORM\Column(name="telefone", type="text")
     * @Assert\NotBlank(
     *     message = "message.contato.error.embranco.telefone"
     * )
     */
    private $telefone;

    /**
     *@var string
     *
     * @ORM\Column(name="assunto", type="text", nullable=true)
     */
    private $assunto;

    /**
     *@var string
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     * @return Contato
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return string
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param string $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

}