<?php

namespace Admin\CommonBundle\Entity;

use Admin\ImageBundle\Entity\IImage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vitrine
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\CommonBundle\Repository\Vitrine\VitrineRepository")
 */
class Vitrine
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
     * @ORM\Column(name="titulo", type="string", length=80, nullable=false)
     * @Assert\NotBlank(
     *     message = "title.vitrine.titulo.empty"
     * )
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="Admin\ImageBundle\Entity\Image", cascade={"persist", "remove"} )
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
     * @var \String
     *
     * @ORM\Column(name="target", type="string", length=255 , nullable=false, options={"default" = "_blank"})
     */
    private $target;

    /**
     * @var \String
     *
     * @ORM\Column(name="ordem", type="integer", nullable=false, options={"default" = 0})
     */
    private $ordem;

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->titulo);
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
     * Set titulo
     *
     * @param string $titulo
     * @return Vitrine
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
     * Set url
     *
     * @param string $url
     * @return Vitrine
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set status
     *
     * @param integer $status
     * @return Vitrine
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
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Vitrine
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     */
    public function setDtCreated($dtCreated)
    {
        if(empty($dtCreated)){
            $this->setDtCreatedDefault();
        }else{
            $this->dtCreated = $dtCreated;
        }
    }

    public function setDtCreatedDefault()
    {
        $this->dtCreated = new \DateTime('now');
    }

    /**
     * Set dtUpdate
     *
     * @param \DateTime $dtUpdate
     * @return Vitrine
     */
    public function setDtUpdate($dtUpdate)
    {
        if(empty($dtUpdate)){
            $this->setDtUpdateDefault();
        }else{
            $this->dtUpdate = $dtUpdate;
        }
    }

    /**
     * Get dtUpdate
     *
     * @return \DateTime
     */
    public function getDtUpdate()
    {
        return $this->dtUpdate;
    }


    public function setDtUpdateDefault()
    {
        $this->dtUpdate = new \DateTime('now');
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
     */
    public function setDtPublicacao($dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
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
     */
    public function setDtExpiracao($dtExpiracao)
    {
        $this->dtExpiracao = $dtExpiracao;
    }

    /**
     * @return String
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param String $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return String
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * @param String $ordem
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
    }

}