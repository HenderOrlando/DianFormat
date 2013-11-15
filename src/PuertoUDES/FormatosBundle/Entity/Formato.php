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
     * @ORM\Column(type="integer", nullable=false, name="numero")
     */
    private $numero;
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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Entidad", inversedBy="formatos")
     * @ORM\JoinColumn(name="id_transportista", referencedColumnName="id", nullable=true)
     */
    private $transportista;

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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="hijos")
     * @ORM\JoinColumn(name="padre", referencedColumnName="id", nullable=true)
     */
    private $padre;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="padre")
     */
    private $hijos;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="formatos")
     * @ORM\JoinColumn(name="tipo", referencedColumnName="id", nullable=false)
     */
    private $tipo;
    
    private $unidadCarga;//Carga
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
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contenedoresMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * Set numero
     *
     * @param integer $numero
     * @return Formato
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }
    
    /**
     * Get padre
     *
     * @return Formato
     */
    public function getPadre()
    {
        return $this->padre;
    }
    
    /**
     * Set padre
     *
     * @param integer $padre
     * @return Formato
     */
    public function setPadre($padre)
    {
        $this->padre = $padre;
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
    public function addConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores)
    {
        $this->conductores[] = $conductores;
    
        return $this;
    }

    /**
     * Remove conductores
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores
     */
    public function removeConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $conductores)
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
     * Add hijos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $hijos
     * @return Formato
     */
    public function addHijo(\PuertoUDES\FormatosBundle\Entity\Formato $hijos)
    {
        $this->hijos[] = $hijos;
    
        return $this;
    }

    /**
     * Remove hijos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $hijos
     */
    public function removeHijo(\PuertoUDES\FormatosBundle\Entity\Formato $hijos)
    {
        $this->hijos->removeElement($hijos);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHijos()
    {
        return $this->hijos;
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
     * Get usuarios
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Entidad
     */
    public function getTransportista()
    {
        return $this->transportista;
    }

    /**
     * Get usuarios
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Entidad $transportista
     * @return Formato
     */
    public function setTransportista($transportista)
    {
        $this->transportista = $transportista;
        
        return $this;
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
    
    public function json($json = true, 
            $padre = false, 
            $gastos = false, 
            $cargas = false, 
            $aduanas = false, 
            $documentos = false, 
            $conductores = false, 
            $contenedoresMercancias = false, 
            $hijos = false){
        $a = array_merge(parent::json(false),
            array(
                'transportista' => method_exists($this->getTransportista(), 'json')?$this->getTransportista()->json(false):null,
                'tipo'          =>  $this->getTipo()->json(false),
                'numero'        =>  $this->getNumero(),
                'completo'      =>  $this->getCompleto(),
            )
        );
        if(is_bool($padre) && $padre){
            $a = array_merge($a, array(
                'padre' => $this->getPadre()->json(false)
            ));
        }
        if(is_bool($aduanas) && $aduanas){
            $a = array_merge($a, array(
                'aduanas' => $this->getAduanas()->json(false)
            ));
        }
        if(is_bool($cargas) && $cargas){
            $a = array_merge($a, array(
                'cargas' => $this->getCargas()->json(false)
            ));
        }
        if(is_bool($conductores) && $conductores){
            $a = array_merge($a, array(
                'conductores' => $this->getConductores()->json(false)
            ));
        }
        if(is_bool($contenedoresMercancias) && $contenedoresMercancias){
            $a = array_merge($a, array(
                'contenedores_mercancias' => $this->getContenedoresMercancias()->json(false)
            ));
        }
        if(is_bool($documentos) && $documentos){
            $a = array_merge($a, array(
                'documentos' => $this->getDocumentos()->json(false)
            ));
        }
        if(is_bool($gastos) && $gastos){
            $a = array_merge($a, array(
                'gastos' => $this->getGastos()->json(false)
            ));
        }
        if(is_bool($hijos) && $hijos){
            $a = array_merge($a, array( 
                'hijos' =>$this->getHijos()->json(false)
            ));
        }
        if(is_bool($hijos) && $hijos){
            $a = array_merge($a, array( 
                'hijos' =>$this->getHijos()->json(false)
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}