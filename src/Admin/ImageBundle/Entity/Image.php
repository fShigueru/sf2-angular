<?php

namespace Admin\ImageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Admin\ImageBundle\Repository\ImageProporcaoRepository")
 */
class Image
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
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     *
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
     * @ORM\OneToMany(targetEntity="ImageProporcao", mappedBy="image", cascade={"persist", "remove"} )
     */
    private $proporcoes;

    /**
     * Inicia Collection para traduções
     *
     */
    public function __construct()
    {
        $this->proporcoes = new ArrayCollection();
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * Set file
     *
     * @param string $file
     * @return string
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
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
     * @return Image
     */
    public function setProporcoes($proporcoes)
    {
        $this->proporcoes = $proporcoes;
        return $this;
    }


    /**
     * @param $proporcoes
     * @return $this
     */
    public function addProporcoes($proporcoes)
    {
        $proporcoes->setImage($this);
        $this->proporcoes[] = $proporcoes;
        return $this;
    }

}
