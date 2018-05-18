<?php

namespace Admin\CommonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Banner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\CommonBundle\Repository\Banner\BannerRepository")
 */
class Banner
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
     * @ORM\Column(name="titulo", type="string", length=50)
     * @Assert\NotBlank(
     *     message = "title.banner.titulo.empty"
     * )
     *
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=80, nullable=true)
     */
    private $url;

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
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false ,options={"default" = 1})
     *
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="Admin\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var \String
     *
     * @ORM\Column(name="target", type="string", length=10 , nullable=false, options={"default" = "_blank"})
     */
    private $target;

    /**
     * @ORM\OneToOne(targetEntity="LocalBanner", inversedBy="banner")
     * @ORM\JoinColumn(name="local_id", referencedColumnName="id")
     * @Assert\NotBlank(
     *     message = "title.banner.titulo.empty"
     * )
     */
    private $local;

    /**
     * Banner constructor.
     */
    public function __construct()
    {
        $this->local = new ArrayCollection();
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
     * @return Banner
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
     * @return Banner
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
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return Banner
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
     * Get dtPublicacao
     *
     * @return \DateTime 
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set dtExpiracao
     *
     * @param \DateTime $dtExpiracao
     * @return Banner
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
     * Get dtExpiracao
     *
     * @return \DateTime 
     */
    public function getDtExpiracao()
    {
        return $this->dtExpiracao;
    }

    /**
     * Set dtCreated
     *
     * @param \DateTime $dtCreated
     * @return Banner
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
     * Get dtCreated
     *
     * @return \DateTime 
     */
    public function getDtCreated()
    {
        return $this->dtCreated;
    }

    /**
     * Set dtUpdate
     *
     * @param \DateTime $dtUpdate
     * @return Banner
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
     * Get dtUpdate
     *
     * @return \DateTime 
     */
    public function getDtUpdate()
    {
        return $this->dtUpdate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Banner
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
     * Set image
     *
     * @param string $image
     * @return Banner
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set target
     *
     * @param string $target
     * @return Banner
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set local
     *
     * @param string $local
     * @return Banner
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string 
     */
    public function getLocal()
    {
        return $this->local;
    }

    public function setDtDefault()
    {
        return new \DateTime('now');
    }

}
