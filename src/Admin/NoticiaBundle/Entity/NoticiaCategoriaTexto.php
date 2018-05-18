<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * NoticiaCategoriaTexto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NoticiaCategoriaTexto
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
     * @ORM\Column(name="nome", type="string", length=50)
     */
    private $nome;

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
     * @ORM\ManyToOne(targetEntity="Admin\CommonBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="sigla")
     **/
    private $idioma;

    /**
     * @ORM\ManyToOne(targetEntity="NoticiaCategoria", inversedBy="textos", fetch="LAZY")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     **/
    private $categoria;


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
     * @return NoticiaCategoriaTexto
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
     * Set slug
     *
     * @param string $slug
     * @return NoticiaCategoriaTexto
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
     * Set idioma
     *
     * @param string $idioma
     * @return NoticiaCategoriaTexto
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
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     * @return NoticiaCategoriaTexto
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

}
