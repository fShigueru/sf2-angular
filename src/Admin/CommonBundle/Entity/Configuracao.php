<?php

namespace Admin\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracao
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\CommonBundle\Repository\Configuracao\ConfiguracaoRepository")
 */
class Configuracao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="chave", type="string", length=255, unique=true, nullable=false)
     */
    private $chave;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255, nullable=false)
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
     */
    private $descricao;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set chave
     *
     * @param string $chave
     * @return Configuracao
     */
    public function setChave($chave)
    {
        $this->chave = $chave;
    
        return $this;
    }

    /**
     * Get chave
     *
     * @return string 
     */
    public function getChave()
    {
        return $this->chave;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return Configuracao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

}
