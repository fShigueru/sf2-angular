<?php

namespace Admin\GaleriaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Galeria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\GaleriaBundle\Repository\GaleriaRepository")
 * @UniqueEntity(
 *     fields={"titulo"},
 *     errorPath="titulo",
 *     message="O campo titulo não pode ser duplicado"
 * )
 */
class Galeria
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
     * @ORM\Column(name="titulo", type="string", length=50, unique=true)
     * @Assert\NotBlank(
     *     message = "title.notblank"
     * )
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=30, nullable=true)
     */
    private $entity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_entity", type="integer", nullable=true)
     */
    private $idEntity;

    /**
     * @ORM\OneToMany(targetEntity="ImageGaleria", mappedBy="galeria", cascade={"persist", "remove"} )
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="cropSizeW", type="string", length=50)
     *
     */
    private $cropSizeW;

    /**
     * @var string
     *
     * @ORM\Column(name="cropSizeH", type="string", length=50)
     */
    private $cropSizeH;

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
     * @ORM\Column(name="dtPublicacao", type="datetime", nullable=true)
     * @Assert\NotBlank(
     *     message = "title.dt.publicacao.notblank"
     * )
     */
    private $dtPublicacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtExpiracao", type="datetime", nullable=true)
     * @Assert\NotBlank(
     *     message = "title.dt.expiracao.notblank"
     * )
     */
    private $dtExpiracao;

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
     * Inicia Collection para traduções
     *
     */
    public function __construct()
    {
        $this->image = new ArrayCollection();
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
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return Galeria
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Set entity
     *
     * @param string $entity
     * @return Galeria
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return int
     */
    public function getIdEntity()
    {
        return $this->idEntity;
    }

    /**
     * @param int $idEntity
     * @return Galeria
     */
    public function setIdEntity($idEntity)
    {
        $this->idEntity = intval($idEntity);
        return $this;
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
     * @return Galeria
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param mixed $image
     * @return Galeria
     */
    public function addImage($image)
    {
        $image->setGaleria($this);
        $this->image[] = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getCropSizeW()
    {
        return $this->cropSizeW;
    }

    /**
     * @param string $cropSizeW
     * @return Galeria
     */
    public function setCropSizeW($cropSizeW)
    {
        $this->cropSizeW = $cropSizeW;
        return $this;
    }

    /**
     * @return string
     */
    public function getCropSizeH()
    {
        return $this->cropSizeH;
    }

    /**
     * @param string $cropSizeH
     * @return Galeria
     */
    public function setCropSizeH($cropSizeH)
    {
        $this->cropSizeH = $cropSizeH;
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
     * @return Galeria
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return Galeria
     */
    public function setDtPublicacao($dtPublicacao)
    {
        if(empty($dtPublicacao)){
            $this->dtPublicacao = $this->setDtDefault();
        }else{
            $this->dtPublicacao = $dtPublicacao;
        }
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
     * @return Galeria
     */
    public function setDtExpiracao($dtExpiracao)
    {
        if(empty($dtExpiracao)){
            $this->dtExpiracao =  new \DateTime("2030-12-01");
        }else{
            $this->dtExpiracao = $dtExpiracao;
        }
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
     * @return Galeria
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
     * @return Galeria
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

    public function setDtDefault()
    {
        return new \DateTime('now');
    }


}
