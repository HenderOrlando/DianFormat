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
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="pais")
     */
    private $formatos;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="paisCompra")
     */
    private $formatosCompra;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="paisOrigen")
     */
    private $formatosOrigen;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="paisBandera")
     */
    private $formatosBandera;
    
    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="cod")
     */
    private $cod;
    
    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="codBandera")
     */
    private $codBandera;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->lugares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->objetos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatosCompra = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatosOrigen = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set cod
     *
     * @param string $cod
     * @return Pais
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
    
        return $this;
    }

    /**
     * Get cod
     *
     * @return string 
     */
    public function getCod()
    {
        return $this->cod;
    }
    
    /**
     * Set codBandera
     *
     * @param string $codBandera
     * @return Pais
     */
    public function setCodBandera($codBandera)
    {
        $this->codBandera = $codBandera;
    
        return $this;
    }

    /**
     * Get codBandera
     *
     * @return string 
     */
    public function getCodBandera()
    {
        return $this->codBandera;
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
        return $this->formatosCompra;
    }
    
    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoCompra $formatos
     * @return Tipo
     */
    public function addFormatoCompra(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosCompra[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoCompra $formatos
     */
    public function removeFormatoCompra(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosCompra->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatoCompras()
    {
        return $this->formatosCompra;
    }
    
    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoBandera $formatos
     * @return Tipo
     */
    public function addFormatoBandera(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosBandera[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoBandera $formatos
     */
    public function removeFormatoBandera(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosBandera->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatoBanderas()
    {
        return $this->formatosBandera;
    }
    
    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoOrigen $formatos
     * @return Tipo
     */
    public function addFormatoOrigen(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosOrigen[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoOrigen $formatos
     */
    public function removeFormatoOrigen(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatosOrigen->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatoOrigens()
    {
        return $this->formatosOrigen;
    }

}