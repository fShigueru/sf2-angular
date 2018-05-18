<?php

namespace Admin\EnderecoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Admin\EnderecoBundle\Entity\Estado;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cidade
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\EnderecoBundle\Entity\CidadeRepository")
 */
class Cidade implements CidadeInterface
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
     * @ORM\Column(name="nome", type="string", length=100, nullable=false)
     * @Assert\NotBlank(
     *     message = "error.empty.input.cidade"
     * )
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="sigla", onDelete="CASCADE")
     * @Assert\NotBlank(
     *     message = "error.empty.select.estado"
     * )
     **/
    private $estado;

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->nome);
    }

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
     * Set nome
     *
     * @param string $nome
     * @return Cidade
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set estado
     *
     * @param \stdClass $estado
     * @return Cidade
     */
    public function setEstado(EstadoInterface $estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \stdClass 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
