<?php

namespace Admin\EnderecoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Bairro
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\EnderecoBundle\Entity\BairroRepository")
 */
class Bairro implements BairroInterface
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
     *     message = "error.empty.input.bairro"
     * )
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Cidade")
     * @ORM\JoinColumn(name="cidade_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(
     *     message = "error.empty.select.cidade"
     * )
     **/
    private $cidade;

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
     * @return Bairro
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
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    public function getCidades(){
        return array($this->cidade);
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade(CidadeInterface $cidade)
    {
        $this->cidade = $cidade;
    }


}
