<?php

namespace Admin\NoticiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoticiaSeoTexto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NoticiaSeoTexto
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
     * @ORM\Column(name="keyWord", type="string", length=255)
     */
    private $keyWord;

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
     * @ORM\ManyToOne(targetEntity="NoticiaSeo", inversedBy="textos", fetch="LAZY")
     * @ORM\JoinColumn(name="seo_id", referencedColumnName="id")
     **/
    private $seo;


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
     * Set keyWord
     *
     * @param string $keyWord
     * @return NoticiaSeoTexto
     */
    public function setKeyWord($keyWord)
    {
        $this->keyWord = $keyWord;

        return $this;
    }

    /**
     * Get keyWord
     *
     * @return string 
     */
    public function getKeyWord()
    {
        return $this->keyWord;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NoticiaSeoTexto
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
     * @return NoticiaSeoTexto
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
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param mixed $seo
     * @return NoticiaSeoTexto
     */
    public function setSeo($seo)
    {
        $this->seo = $seo;
        return $this;
    }

}
