<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NoticiaSeo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NoticiaSeo
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
     * @ORM\OneToMany(targetEntity="NoticiaSeoTexto", mappedBy="seo", cascade={"persist", "remove"} )
     */
    private $textos;

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
     * @return mixed
     */
    public function getTextos()
    {
        return $this->textos;
    }

  /**
     * @param mixed $textos
     * @return NoticiaSeo
     */
    public function setTextos($textos)
    {
        $this->textos = $textos;
        return $this;
    }

    /**
     * @param mixed $textos
     * @return NoticiaSeo
     */
    public function addTextos($textos)
    {
        $this->setSeo($this);
        $this->textos[] = $textos;
        return $this;
    }


}
