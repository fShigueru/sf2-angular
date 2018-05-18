<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NoticiaCategoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\NoticiaBundle\Repository\NoticiaCategoriaRepository")
 */
class NoticiaCategoria
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
     * @ORM\OneToMany(targetEntity="NoticiaCategoriaTexto", mappedBy="categoria", cascade={"persist", "remove"} )
     */
    private $textos;

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
     * @ORM\OneToMany(targetEntity="Noticia", mappedBy="categoria", cascade={"persist", "remove"} )
     */
    private $noticia;

    /**
     * Inicia Collection para textos
     *
     */
    public function __construct()
    {
        $this->textos = new ArrayCollection();
        $this->noticia = new ArrayCollection();
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
     * @return NoticiaCategoria
     */
    public function setTextos($textos)
    {
        $this->textos = $textos;
        return $this;
    }

    /**
     * @param mixed $textos
     * @return NoticiaCategoria
     */
    public function addTextos($textos)
    {
        $textos->setCategoria($this);
        $this->textos[] = $textos;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return NoticiaCategoria
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
     * @return NoticiaCategoria
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
     * @return NoticiaCategoria
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
     * @return mixed
     */
    public function getNoticia()
    {
        return $this->noticia;
    }

    /**
     * @param mixed $noticia
     * @return NoticiaCategoria
     */
    public function setNoticia($noticia)
    {
        $this->noticia = $noticia;
        return $this;
    }

    /**
     * @param mixed $noticia
     * @return NoticiaCategoria
     */
    public function addNoticia($noticia)
    {
        $noticia->setCategoria($this);
        $this->noticia[] = $noticia;
        return $this;
    }


    public function setDtDefault()
    {
        return new \DateTime('now');
    }
}
