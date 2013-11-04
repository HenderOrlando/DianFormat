<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tipo")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\TipoRepository")
 */
class Tipo extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", nullable=false, name="_aplicable_a")
     */
    private $_aplicableA;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="tipo")
     */
    private $formatos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoAduana", mappedBy="nivel")
     */
    private $fomatoAduanas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="naturalezaCarga")
     */
    private $cargas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Conductor", mappedBy="claseLicencia")
     */
    private $conductores;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fomatoAduanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set _aplicableA
     *
     * @param string $aplicableA
     * @return Tipo
     */
    public function setAplicableA($aplicableA)
    {
        $this->_aplicableA = $aplicableA;
    
        return $this;
    }

    /**
     * Get _aplicableA
     *
     * @return string 
     */
    public function getAplicableA()
    {
        return $this->_aplicableA;
    }

    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     * @return Tipo
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

    /**
     * Add fomatoAduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatoAduanas
     * @return Tipo
     */
    public function addFomatoAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatoAduanas)
    {
        $this->fomatoAduanas[] = $fomatoAduanas;
    
        return $this;
    }

    /**
     * Remove fomatoAduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatoAduanas
     */
    public function removeFomatoAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatoAduanas)
    {
        $this->fomatoAduanas->removeElement($fomatoAduanas);
    }

    /**
     * Get fomatoAduanas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFomatoAduanas()
    {
        return $this->fomatoAduanas;
    }

    /**
     * Add cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     * @return Tipo
     */
    public function addCarga(\PuertoUDES\FormatosBundle\Entity\Carga $cargas)
    {
        $this->cargas[] = $cargas;
    
        return $this;
    }

    /**
     * Remove cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     */
    public function removeCarga(\PuertoUDES\FormatosBundle\Entity\Carga $cargas)
    {
        $this->cargas->removeElement($cargas);
    }

    /**
     * Get cargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargas()
    {
        return $this->cargas;
    }

    /**
     * Add conductores
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Conductor $conductores
     * @return Tipo
     */
    public function addConductore(\PuertoUDES\UsuariosBundle\Entity\Conductor $conductores)
    {
        $this->conductores[] = $conductores;
    
        return $this;
    }

    /**
     * Remove conductores
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Conductor $conductores
     */
    public function removeConductore(\PuertoUDES\UsuariosBundle\Entity\Conductor $conductores)
    {
        $this->conductores->removeElement($conductores);
    }

    /**
     * Get conductores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConductores()
    {
        return $this->conductores;
    }
}