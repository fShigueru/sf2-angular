<?php

namespace Admin\PaginaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PaginaTexto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PaginaTexto
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
     * @ORM\Column(name="titulo", type="string", length=50, nullable=false)
     * @Assert\NotBlank(
     *     message = "message.error.pagina.texto.titulo"
     * )
     *
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="subTitulo", type="string", length=80, nullable=true)
     */
    private $subTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=70, nullable=false, unique=true)
     * @Assert\NotNull()
     * @Assert\NotBlank(
     *     message = "message.error.pagina.texto.slug"
     * )
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Pagina", inversedBy="paginaTextos", fetch="LAZY")
     * @ORM\JoinColumn(name="pagina_id", referencedColumnName="id")
     **/
    private $pagina;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CommonBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="sigla")
     **/
    private $idioma;



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
     * Set titulo
     *
     * @param string $titulo
     * @return PaginaTexto
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set subTitulo
     *
     * @param string $subTitulo
     * @return PaginaTexto
     */
    public function setSubTitulo($subTitulo)
    {
        $this->subTitulo = $subTitulo;

        return $this;
    }

    /**
     * Get subTitulo
     *
     * @return string 
     */
    public function getSubTitulo()
    {
        return $this->subTitulo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return PaginaTexto
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return PaginaTexto
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * @param mixed $pagina
     * @return PaginaTexto
     */
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param mixed $idioma
     * @return PaginaTexto
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
        return $this;
    }



}
