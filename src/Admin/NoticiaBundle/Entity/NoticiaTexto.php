<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NoticiaTexto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NoticiaTexto
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
     * @ORM\Column(name="titulo", type="string", length=80)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="subTitulo", type="string", length=140)
     */
    private $subTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CommonBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="sigla")
     **/
    private $idioma;

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
     * @ORM\ManyToOne(targetEntity="Noticia", inversedBy="textos", fetch="LAZY")
     * @ORM\JoinColumn(name="noticia_id", referencedColumnName="id")
     **/
    private $noticia;


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
     * @return NoticiaTexto
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
     * @return NoticiaTexto
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
     * @return NoticiaTexto
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
     * Set idioma
     *
     * @param string $idioma
     * @return NoticiaTexto
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NoticiaTexto
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
    public function getNoticia()
    {
        return $this->noticia;
    }

    /**
     * @param mixed $noticia
     * @return NoticiaTexto
     */
    public function setNoticia($noticia)
    {
        $this->noticia = $noticia;
        return $this;
    }

}
