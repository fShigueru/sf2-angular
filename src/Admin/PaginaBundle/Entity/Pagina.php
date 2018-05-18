<?php

namespace Admin\PaginaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Pagina
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\PaginaBundle\Repository\PaginaRepository")
 */
class Pagina
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     *
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtPublicacao", type="datetime")
     */
    private $dtPublicacao;

    /**
     * @ORM\OneToMany(targetEntity="PaginaTexto", mappedBy="pagina", cascade={"persist", "remove"} )
     */
    private $paginaTextos;

    /**
     * @ORM\OneToMany(targetEntity="PaginaSeo", mappedBy="pagina", cascade={"persist", "remove"} )
     */
    private $paginaSeo;

    private $route;

    /**
     * @ORM\OneToOne(targetEntity="Admin\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     */
    protected $image;



    /**
     * Inicia Collection para traduções
     *
     */
    public function __construct()
    {
        $this->paginaTextos = new ArrayCollection();
        $this->paginaSeo = new ArrayCollection();
    }

    public function _toString()
    {
        foreach($this->paginaTextos as $list){
            return $list->getTitulo();
        }
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
     * Set created
     *
     * @param \DateTime $created
     * @return Pagina
     */
    public function setCreated($created)
    {
        if(empty($created)){
            $this->created = $this->setDtDefault();
        }else{
            $this->created = $created;
        }
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Pagina
     */
    public function setUpdated($updated)
    {
        if(empty($updated)){
            $this->updated = $this->setDtDefault();
        }else{
            $this->updated = $updated;
        }

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Pagina
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return Pagina
     */
    public function setDtPublicacao($dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;

        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime 
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * @return mixed
     */
    public function getPaginaTextos()
    {
        return $this->paginaTextos;
    }

    /**
     * @param mixed $paginaTextos
     * @return Pagina
     */
    public function setPaginaTextos($paginaTextos)
    {
        $this->paginaTextos = $paginaTextos;
        return $this;
    }

    /**
     * @param string $paginaTextos
     * @return PaginaTexto
     */
    public function addPaginaTextos($paginaTextos)
    {
        $paginaTextos->setPagina($this);
        $this->paginaTextos[] = $paginaTextos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaginaSeo()
    {
        return $this->paginaSeo;
    }

    /**
     * @param mixed $paginaSeo
     * @return Pagina
     */
    public function setPaginaSeo($paginaSeo)
    {
        $this->paginaSeo = $paginaSeo;
        return $this;
    }

    /**
     * @param string $paginaSeo
     * @return PaginaSeo
     */
    public function addPaginaSeo($paginaSeo)
    {
        $paginaSeo->setPagina($this);
        $this->paginaSeo[] = $paginaSeo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        return $this->foto = $foto;
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
     * @return Pagina
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }


    public function setDtDefault()
    {
        return new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route = "app_pagina";
    }

}
