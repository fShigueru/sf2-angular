<?php

namespace Admin\EnderecoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Estado
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Estado implements EstadoInterface
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="sigla", type="string", length=2, nullable=false)
     * @Assert\NotBlank(
     *     message = "error.empty.input.estado"
     * )
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=100, nullable=true)
     */
    private $descricao;

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->sigla);
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Estado
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Estado
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
}
