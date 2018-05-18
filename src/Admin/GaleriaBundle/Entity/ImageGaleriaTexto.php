<?php

namespace Admin\GaleriaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageGaleriaTexto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ImageGaleriaTexto
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
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitulo", type="text")
     */
    private $subtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CommonBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="sigla")
     **/
    private $idioma;

    /**
     * @ORM\ManyToOne(targetEntity="ImageGaleria", inversedBy="textos", fetch="LAZY")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    private $imageGaleria;


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
     * @return imageGaleriaTexto
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
     * Set subtitulo
     *
     * @param string $subtitulo
     * @return imageGaleriaTexto
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    /**
     * Get subtitulo
     *
     * @return string 
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return imageGaleriaTexto
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set idioma
     *
     * @param string $idioma
     * @return imageGaleriaTexto
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @return mixed
     */
    public function getImageGaleria()
    {
        return $this->imageGaleria;
    }

    /**
     * @param mixed $imageGaleria
     * @return imageGaleriaTexto
     */
    public function setImageGaleria($imageGaleria)
    {
        $this->imageGaleria = $imageGaleria;
        return $this;
    }

}
