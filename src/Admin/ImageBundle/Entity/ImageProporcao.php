<?php

namespace Admin\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FotoProporcao
 * @ORM\Table(name="image_proporcao")
 * @ORM\Entity(repositoryClass="Admin\ImageBundle\Entity\ImageProporcaoRepository")
 */
class ImageProporcao
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
     * @ORM\Column(name="cropStartLeft", type="string", length=50, nullable=true)
     */
    private $cropStartLeft;

    /**
     * @var string
     *
     * @ORM\Column(name="cropStartTop", type="string", length=50, nullable=true)
     */
    private $cropStartTop;

    /**
     * @var string
     *
     * @ORM\Column(name="cropSizeW", type="string", length=50, nullable=true)
     */
    private $cropSizeW;

    /**
     * @var string
     *
     * @ORM\Column(name="cropSizeH", type="string", length=50, nullable=true)
     */
    private $cropSizeH;

    /**
     * @var string
     *
     * @ORM\Column(name="scale", type="string", length=255, nullable=true)
     */
    private $scale;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbW", type="string", length=50, nullable=true)
     */
    private $thumbW;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbH", type="string", length=50, nullable=true)
     */
    private $thumbH;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="proporcoes", fetch="LAZY")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    private $image;

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
     * Set cropStartLeft
     *
     * @param string $cropStartLeft
     * @return ImageProporcao
     */
    public function setCropStartLeft($cropStartLeft)
    {
        $this->cropStartLeft = $cropStartLeft;

        return $this;
    }

    /**
     * Get cropStartLeft
     *
     * @return string 
     */
    public function getCropStartLeft()
    {
        return $this->cropStartLeft;
    }

    /**
     * Set cropStartTop
     *
     * @param string $cropStartTop
     * @return ImageProporcao
     */
    public function setCropStartTop($cropStartTop)
    {
        $this->cropStartTop = $cropStartTop;

        return $this;
    }

    /**
     * Get cropStartTop
     *
     * @return string 
     */
    public function getCropStartTop()
    {
        return $this->cropStartTop;
    }

    /**
     * Set cropSizeW
     *
     * @param string $cropSizeW
     * @return ImageProporcao
     */
    public function setCropSizeW($cropSizeW)
    {
        $this->cropSizeW = $cropSizeW;

        return $this;
    }

    /**
     * Get cropSizeW
     *
     * @return string 
     */
    public function getCropSizeW()
    {
        return $this->cropSizeW;
    }

    /**
     * Set cropSizeH
     *
     * @param string $cropSizeH
     * @return ImageProporcao
     */
    public function setCropSizeH($cropSizeH)
    {
        $this->cropSizeH = $cropSizeH;

        return $this;
    }

    /**
     * Get cropSizeH
     *
     * @return string 
     */
    public function getCropSizeH()
    {
        return $this->cropSizeH;
    }

    /**
     * Set scale
     *
     * @param string $scale
     * @return ImageProporcao
     */
    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * Get scale
     *
     * @return string 
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * Set thumbW
     *
     * @param string $thumbW
     * @return ImageProporcao
     */
    public function setThumbW($thumbW)
    {
        $this->thumbW = $thumbW;

        return $this;
    }

    /**
     * Get thumbW
     *
     * @return string 
     */
    public function getThumbW()
    {
        return $this->thumbW;
    }

    /**
     * Set thumbH
     *
     * @param string $thumbH
     * @return ImageProporcao
     */
    public function setThumbH($thumbH)
    {
        $this->thumbH = $thumbH;

        return $this;
    }

    /**
     * Get thumbH
     *
     * @return string 
     */
    public function getThumbH()
    {
        return $this->thumbH;
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
     * @return ImageProporcao
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

}
