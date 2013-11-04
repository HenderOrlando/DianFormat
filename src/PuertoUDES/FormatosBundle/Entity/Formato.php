<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="formato")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\FormatoRepository")
 */
class Formato extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="boolean", nullable=false, name="completo")
     */
    private $completo;
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\CommonBundle\Entity\Documento", mappedBy="formato")
     */
    private $documentos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoConductor", mappedBy="formato")
     */
    private $conductores;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoAduana", mappedBy="formato")
     */
    private $aduanas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="formato")
     */
    private $usuarios;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="formato")
     */
    private $cargas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", mappedBy="formato")
     */
    private $contenedoresMercancias;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="formato")
     */
    private $gastos;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="formatos")
     * @ORM\JoinColumn(name="tipo", referencedColumnName="id", nullable=false)
     */
    private $tipo;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->completo = false;
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aduanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contenedoresMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get completo
     *
     * @return boolean
     */
    public function getCompleto()
    {
        return $this->completo;
    }
    
    /**
     * Set completo
     *
     * @param boolean $completo
     * @return Formato
     */
    public function setCompleto($completo)
    {
        $this->completo = $completo;
        return $this;
    }
    /**
     * Add documentos
     *
     * @param \PuertoUDES\CommonBundle\Entity\Documento $documentos
     * @return Formato
     */
    public function addDocumento(\PuertoUDES\CommonBundle\Entity\Documento $documentos)
    {
        $this->documentos[] = $documentos;
    
        return $this;
    }

    /**
     * Remove documentos
     *
     * @param \PuertoUDES\CommonBundle\Entity\Documento $documentos
     */
    public function removeDocumento(\PuertoUDES\CommonBundle\Entity\Documento $documentos)
    {
        $this->documentos->removeElement($documentos);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }

    /**
     * Add conductores
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores
     * @return Formato
     */
    public function addConductore(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores)
    {
        $this->conductores[] = $conductores;
    
        return $this;
    }

    /**
     * Remove conductores
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores
     */
    public function removeConductore(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores)
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
     * Add aduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $aduanas
     * @return Formato
     */
    public function addAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $aduanas)
    {
        $this->aduanas[] = $aduanas;
    
        return $this;
    }

    /**
     * Remove aduanas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $aduanas
     */
    public function removeAduana(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $aduanas)
    {
        $this->aduanas->removeElement($aduanas);
    }

    /**
     * Get aduanas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanas()
    {
        return $this->aduanas;
    }

    /**
     * Add usuarios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuarios
     * @return Formato
     */
    public function addUsuario(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuarios)
    {
        $this->usuarios[] = $usuarios;
    
        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuarios
     */
    public function removeUsuario(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Add cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     * @return Formato
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
     * Add contenedoresMercancias
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresMercancias
     * @return Formato
     */
    public function addContenedoresMercancia(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresMercancias)
    {
        $this->contenedoresMercancias[] = $contenedoresMercancias;
    
        return $this;
    }

    /**
     * Remove contenedoresMercancias
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresMercancias
     */
    public function removeContenedoresMercancia(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresMercancias)
    {
        $this->contenedoresMercancias->removeElement($contenedoresMercancias);
    }

    /**
     * Get contenedoresMercancias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedoresMercancias()
    {
        return $this->contenedoresMercancias;
    }

    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     * @return Formato
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
     * Set tipo
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $tipo
     * @return Formato
     */
    public function setTipo(\PuertoUDES\CommonBundle\Entity\Tipo $tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}