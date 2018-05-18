<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Noticia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\NoticiaBundle\Repository\NoticiaRepository")
 */
class Noticia
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
     * @ORM\OneToMany(targetEntity="NoticiaTexto", mappedBy="noticia", cascade={"persist", "remove"} )
     */
    private $textos;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=50)
     */
    private $autor;

    /**
     * @ORM\ManyToOne(targetEntity="NoticiaCategoria", inversedBy="noticia", fetch="LAZY")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     **/
    private $categoria;


    /**
     * @ORM\OneToOne(targetEntity="NoticiaSeo", mappedBy="noticia", cascade={"persist", "remove"} )
     */
    private $seo;


    /**
     * @ORM\OneToOne(targetEntity="Admin\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     */
    protected $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false ,options={"default" = 1})
     *
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtCreated", type="datetime")
     */
    private $dtCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtUpdate", type="datetime")
     */
    private $dtUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtPublicacao", type="datetime", nullable=true)
     */
    private $dtPublicacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtExpiracao", type="datetime", nullable=true)
     */
    private $dtExpiracao;

    /**
     * Inicia Collection para textos
     *
     */
    public function __construct()
    {
        $this->textos = new ArrayCollection();
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
     * @return mixed
     */
    public function getTextos()
    {
        return $this->textos;
    }

    /**
     * @param mixed $textos
     * @return Noticia
     */
    public function setTextos($textos)
    {
        $this->textos = $textos;
        return $this;
    }

    /**
     * @param mixed $textos
     * @return Noticia
     */
    public function addTextos($textos)
    {
        $textos->setNoticia($this);
        $this->textos[] = $textos;
        return $this;
    }


    /**
     * Set autor
     *
     * @param string $autor
     * @return Noticia
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Noticia
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set seo
     *
     * @param string $seo
     * @return Noticia
     */
    public function setSeo($seo)
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return string 
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Noticia
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Noticia
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtCreated()
    {
        return $this->dtCreated;
    }

    /**
     * @param \DateTime $dtCreated
     * @return Noticia
     */
    public function setDtCreated($dtCreated)
    {
        if(empty($dtCreated)){
            $this->dtCreated = $this->setDtDefault();
        }else{
            $this->dtCreated = $dtCreated;
        }
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtUpdate()
    {
        return $this->dtUpdate;
    }

    /**
     * @param \DateTime $dtUpdate
     * @return Noticia
     */
    public function setDtUpdate($dtUpdate)
    {
        if(empty($dtUpdate)){
            $this->dtUpdate = $this->setDtDefault();
        }else{
            $this->dtUpdate = $dtUpdate;
        }
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * @param \DateTime $dtPublicacao
     * @return Noticia
     */
    public function setDtPublicacao($dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtExpiracao()
    {
        return $this->dtExpiracao;
    }

    /**
     * @param \DateTime $dtExpiracao
     * @return Noticia
     */
    public function setDtExpiracao($dtExpiracao)
    {
        $this->dtExpiracao = $dtExpiracao;
        return $this;
    }

    public function setDtDefault()
    {
        return new \DateTime('now');
    }
}
