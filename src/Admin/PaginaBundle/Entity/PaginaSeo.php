<?php

namespace Admin\PaginaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PaginaSeo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PaginaSeo
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
     * @ORM\Column(name="descricao", type="string", length=160)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="keyWord", type="string", length=50)
     */
    private $keyWord;

    /**
     * @ORM\ManyToOne(targetEntity="Pagina", inversedBy="paginaSeo")
     * @ORM\JoinColumn(name="pagina_id", referencedColumnName="id")
     *
     **/
    private $pagina;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CommonBundle\Entity\Idioma")
     * @ORM\JoinColumn(name="idioma_id", referencedColumnName="sigla")
     **/
    private $idioma;



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
     * Set descricao
     *
     * @param string $descricao
     * @return PaginaSeo
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
     * Set keyWord
     *
     * @param string $keyWord
     * @return PaginaSeo
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
     * @return mixed
     */
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * @param mixed $pagina
     * @return PaginaSeo
     */
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param mixed $idioma
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    }

}
