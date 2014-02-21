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
    private $aplicableA;
    
    /** 
     * @ORM\Column(type="string", nullable=true, name="abreviacion")
     */
    private $abreviacion;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="tipo")
     */
    private $formatos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoAduana", mappedBy="nivel")
     */
    private $formatoAduanas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="naturalezaCarga")
     */
    private $cargas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Conductor", mappedBy="claseLicencia")
     */
    private $conductores;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="concepto")
     */
    private $gastos;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Condicion", mappedBy="tipo")
     */
    private $condiciones;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato", mappedBy="tipo")
     */
    private $datosMercancias;
    
    private $fullName;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->abreviacion = '';
        $this->fullName = '';
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatoAduanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conceptosGastos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set abreviacion
     *
     * @param string $abreviacion
     * @return Tipo
     */
    public function setAbreviacion($abreviacion)
    {
        $this->abreviacion = $abreviacion;
    
        return $this;
    }
    
    /**
     * Get Abreviacion
     *
     * @return string 
     */
    public function getAbreviacion()
    {
        return $this->abreviacion;
    }
    
    /**
     * Get FullName
     *
     * @return string 
     */
    public function getFullName()
    {
        if(is_null($this->fullName) || empty($this->fullName)){
            $this->fullName = $this->getNombre().' - '.$this->getDescripcion();
        }
        return $this->fullName;
    }
    
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tipo
     */
    public function setNombre($nombre)
    {
        parent::setNombre($nombre);
        if(empty($this->abreviacion)){
            $canonical = $this->getCanonical();
            $a = explode('-', $canonical);
            $c = count($a);
            $str = '';
            if($c > 1)
                foreach($a as $w){
                    if(strlen($w) > 3)
                        $str .= $canonical[0];
                }
            else
                $str = substr ($canonical, 0,4);
            $this->setAbreviacion(strtolower($str));
        }
        
        return $this;
    }
    
    /**
     * Set aplicableA
     *
     * @param string $aplicableA
     * @return Tipo
     */
    public function setAplicableA($aplicableA)
    {
        $this->aplicableA = $aplicableA;
    
        return $this;
    }

    /**
     * Get aplicableA
     *
     * @return string 
     */
    public function getAplicableA()
    {
        return $this->aplicableA;
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
     * Add formatoAduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $formatoAduanas
     * @return Tipo
     */
    public function addFomatoAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $formatoAduanas)
    {
        $this->formatoAduanas[] = $formatoAduanas;
    
        return $this;
    }

    /**
     * Remove formatoAduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $formatoAduanas
     */
    public function removeFomatoAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $formatoAduanas)
    {
        $this->formatoAduanas->removeElement($formatoAduanas);
    }

    /**
     * Get formatoAduanas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatoAduanas()
    {
        return $this->formatoAduanas;
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

    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     * @return Tipo
     */
    public function addGasto(\PuertoUDES\FormatosBundle\Entity\Gasto $gastos)
    {
        $this->gastos[] = $gastos;
    
        return $this;
    }

    /**
     * Remove gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     */
    public function removeGasto(\PuertoUDES\FormatosBundle\Entity\Gasto $gastos)
    {
        $this->gastos->removeElement($gastos);
    }

    /**
     * Get gastos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastos()
    {
        return $this->gastos;
    }
    /**
     * Add condiciones
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Condicion $condiciones
     * @return Tipo
     */
    public function addCondicion(\PuertoUDES\FormatosBundle\Entity\Condicion $condiciones)
    {
        $this->condiciones[] = $condiciones;
    
        return $this;
    }

    /**
     * Remove condiciones
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Condicion $condiciones
     */
    public function removeCondicion(\PuertoUDES\FormatosBundle\Entity\Condicion $condiciones)
    {
        $this->condiciones->removeElement($condiciones);
    }

    /**
     * Get condiciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondiciones()
    {
        return $this->condiciones;
    }
    /**
     * Add datosMercancias
     *
     * @param \PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercancias
     * @return Tipo
     */
    public function addDatosMercancias(\PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercancias)
    {
        $this->datosMercancias[] = $datosMercancias;
    
        return $this;
    }

    /**
     * Remove datosMercancias
     *
     * @param \PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercancias
     */
    public function removeDatosMercancias(\PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercancias)
    {
        $this->datosMercancias->removeElement($datosMercancias);
    }

    /**
     * Get datosMercancias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosMercancias()
    {
        return $this->datosMercancias;
    }
}