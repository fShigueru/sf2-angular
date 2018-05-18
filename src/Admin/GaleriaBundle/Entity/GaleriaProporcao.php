<?php

namespace Admin\GaleriaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GaleriaProporcao
 * @ORM\Table(name="galeria_proporcao")
 * @ORM\Entity()
 */
class GaleriaProporcao
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
     * @return GaleriaProporcao
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
     * @return GaleriaProporcao
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
     * Set scale
     *
     * @param string $scale
     * @return GaleriaProporcao
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
     * @return GaleriaProporcao
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
     * @return GaleriaProporcao
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

}
