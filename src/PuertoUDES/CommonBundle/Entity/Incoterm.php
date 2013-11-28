<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="incoterm")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\IncotermRepository")
 */
class Incoterm extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", length=4, nullable=false, name="sigla")
     */
    private $sigla;
    
    /** 
     * @ORM\Column(type="string", length=1, nullable=false, name="categoria")
     */
    private $categoria;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="incoterm")
     */
    private $formatos;
    
    /** 
     * @ORM\Column(type="integer", length=4, nullable=false, name="anio")
     */
    private $anio;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }




    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Incoterm
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Incoterm
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     * @return Incoterm
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    
        return $this;
    }

    /**
     * Get anio
     *
     * @return integer 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     * @return Incoterm
     */
    public function addFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     */
    public function removeFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->formatos;
    }
    
    public function __toString() {
        return $this->getSigla();
    }
}