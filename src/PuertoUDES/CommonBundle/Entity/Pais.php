<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\PaisRepository")
 */
class Pais extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", length=100, nullable=false, name="nacionalidad")
     */
    private $nacionalidad;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar", mappedBy="pais")
     */
    private $lugares;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\CommonBundle\Entity\ObjetoB", mappedBy="pais")
     */
    private $objetos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Conductor", mappedBy="pais")
     */
    private $conductores;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="tipo")
     */
    private $formatos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->lugares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     * @return Pais
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;
    
        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string 
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Add lugares
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugares
     * @return Pais
     */
    public function addLugar(\PuertoUDES\CommonBundle\Entity\Lugar $lugares)
    {
        $this->lugares[] = $lugares;
    
        return $this;
    }

    /**
     * Remove lugares
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugares
     */
    public function removeLugar(\PuertoUDES\CommonBundle\Entity\Lugar $lugares)
    {
        $this->lugares->removeElement($lugares);
    }

    /**
     * Get lugares
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLugares()
    {
        return $this->lugares;
    }

    /**
     * Add objetos
     *
     * @param \PuertoUDES\CommonBundle\Entity\ObjetoB $objetos
     * @return Pais
     */
    public function addObjeto(\PuertoUDES\CommonBundle\Entity\ObjetoB $objetos)
    {
        $this->objetos[] = $objetos;
    
        return $this;
    }

    /**
     * Remove objetos
     *
     * @param \PuertoUDES\CommonBundle\Entity\ObjetoB $objetos
     */
    public function removeObjeto(\PuertoUDES\CommonBundle\Entity\ObjetoB $objetos)
    {
        $this->objetos->removeElement($objetos);
    }

    /**
     * Get objetos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjetos()
    {
        return $this->objetos;
    }

    /**
     * Add conductores
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Conductor $conductores
     * @return Pais
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

    /**
     * Has lugar
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugar
     * @return boolean
     */
    public function hasLugar($lugar) {
        return $this->getLugares()->exists(function($key,\PuertoUDES\CommonBundle\Entity\Lugar $element) use ($lugar) {
            if($lugar->getId() === $element->getId())
                return true;
            return false;
        });
    }
    
    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE).' '
            .$this->getNacionalidad();
        if(is_bool($explode) && $explode){
            $a = explode(' ', $a);
        }
        return $a;
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

}