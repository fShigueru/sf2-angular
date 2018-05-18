<?php
/**
 * http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/association-mapping.html
 */

namespace Admin\MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Admin\MenuBundle\Repository\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="route", type="string", length=30, nullable=true)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=20, nullable=true)
     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicao", type="integer", options={"default" = 0}, nullable=true)
     */
    private $posicao;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=100, nullable=true)
     */
    private $classe;

    /**
     * @var integer
     *
     * @ORM\Column(name="classe_id", type="integer", nullable=true)
     */
    private $classe_id;


    private $entity;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", options={"default" = 0})
     *
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="menuPai")
     */
    private $menuFilho;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuFilho")
     * @ORM\JoinColumn(name="submenu_id", referencedColumnName="id")
     */
    private $menuPai;

    public function __construct() {
        $this->menuFilho = new ArrayCollection();
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
     * Set route
     *
     * @param string $route
     * @return Menu
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Menu
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set posicao
     *
     * @param integer $posicao
     * @return Menu
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;

        return $this;
    }

    /**
     * Get posicao
     *
     * @return integer 
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Menu
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param mixed $classe
     * @return Menu
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClasseId()
    {
        return $this->classe_id;
    }

    /**
     * @param mixed $classe_id
     * @return Menu
     */
    public function setClasseId($classe_id)
    {
        $this->classe_id = $classe_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Pagina
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
     * @return mixed
     */
    public function getMenuFilho()
    {
        return $this->menuFilho;
    }

    /**
     * @param mixed $menuFilho
     * @return Menu
     */
    public function setMenuFilho($menuFilho)
    {
        $this->menuFilho = $menuFilho;
        return $this;
    }


    /**
     * @param mixed $menuFilho
     * @return Menu
     */
    public function addMenuFilho($menuFilho)
    {
        $this->menuFilho[] = $menuFilho;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuPai()
    {
        return $this->menuPai;
    }

    /**
     * @param mixed $menuPai
     */
    public function setMenuPai($menuPai)
    {
        $this->menuPai = $menuPai;
    }

}
