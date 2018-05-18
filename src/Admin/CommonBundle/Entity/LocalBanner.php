<?php

namespace Admin\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocalBanner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\CommonBundle\Repository\Banner\LocalBannerRepository")
 */
class LocalBanner
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
     * @ORM\Column(name="local", type="string", length=100)
     */
    private $local;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;


    /**
     * @ORM\OneToOne(targetEntity="Banner", mappedBy="local")
     */
    private $banner;

    function __toString()
    {
        return $this->getLocal() .' - ('.$this->getWidth().'x'.$this->getHeight().')';
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
     * Set local
     *
     * @param string $local
     * @return LocalBanner
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

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $width
     * @return LocalBanner
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $height
     * @return LocalBanner
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     * @return LocalBanner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
        return $this;
    }

}
