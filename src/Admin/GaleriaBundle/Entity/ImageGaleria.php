<?php

namespace Admin\GaleriaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageGaleria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\GaleriaBundle\Repository\ImageGaleriaRepository")
 */
class ImageGaleria
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
     * @ORM\ManyToOne(targetEntity="Galeria", inversedBy="image")
     * @ORM\JoinColumn(name="galeria_id", referencedColumnName="id")
     **/
    private $galeria;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "title.upload.mb.max",
     *     mimeTypesMessage = "title.upload.mimetypes"
     * )
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="ImageGaleriaTexto", mappedBy="imageGaleria", cascade={"persist", "remove"} )
     */
    private $textos;

    /**
     * @ORM\OneToOne(targetEntity="GaleriaProporcao", cascade={"persist", "remove"} )
     */
    private $proporcoes;

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
     * Set galeria
     *
     * @param string $galeria
     * @return imageGaleria
     */
    public function setGaleria($galeria)
    {
        $this->galeria = $galeria;

        return $this;
    }

    /**
     * Get galeria
     *
     * @return string 
     */
    public function getGaleria()
    {
        return $this->galeria;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return imageGaleria
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return imageGaleria
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
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
     * @return imageGaleria
     */
    public function setTextos($textos)
    {
        $this->textos = $textos;
        return $this;
    }


    /**
     * @param $textos
     * @return $this
     */
    public function addTextos($textos)
    {
        $textos->setImageGaleria($this);
        $this->textos[] = $textos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProporcoes()
    {
        return $this->proporcoes;
    }

    /**
     * @param mixed $proporcoes
     * @return ImageGaleria
     */
    public function setProporcoes($proporcoes)
    {
        $this->proporcoes = $proporcoes;
        return $this;
    }



}
