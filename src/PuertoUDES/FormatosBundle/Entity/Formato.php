<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\Criteria;

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
     * @ORM\Column(type="text", nullable=true, name="instrucciones")
     */
    private $instrucciones;
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="observaciones")
     */
    private $observaciones;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="formato")
     */
    private $usuarios;
    
    private $notificados;
    private $consignatarios;
    private $remitentes;
    private $destinatarios;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato", mappedBy="formato")
     */
    private $datosMercancias;

    private $datosRecibe;
    private $datosEmbarque;
    private $datosEntrega;
    private $datosEmision;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Condicion", mappedBy="formato")
     */
    private $condiciones;
    
    private $condicionesTransporte;
    private $condicionesPago;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoAduana", mappedBy="formato")
     */
    private $aduanas;
    
    private $aduanasDestino;
    private $aduanasCruce;
    private $aduanasPartida;

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
    
    private $gastoMercancias;
    private $gastosAPagarRemitente;
    private $gastosAPagarDestinatario;

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
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Incoterm", inversedBy="formatos")
     * @ORM\JoinColumn(name="incoterm", referencedColumnName="id", nullable=true)
     */
    private $incoterm;
    
    private $totalPesoBruto;
    private $totalPesoNeto;
    private $totalVolumen;
    private $totalVolumenOtro;
    
    private $gastoTotalMercancias;
    private $gastoTotalRemitente;
    private $gastoTotalDestinatario;
    
    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_emision")
     */
    private $fechaEmision;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->completo = false;
        $this->fechaEmision = new \DateTime("now");
        $this->documentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conductores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aduanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contenedoresMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notificados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consignatarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->remitentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->destinatarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condiciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->totalPesoBruto = $this->totalPesoNeto = $this->totalVolumen = $this->totalVolumenOtro = $this->gastoTotalDestinatario = $this->gastoTotalRemitente = $this->gastoTotalMercancias = 0;
    }
    
    /**
     * Set fechaEmision
     *
     * @param \DateTime $fechaEmision
     * @return Objeto
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;
    
        return $this;
    }

    /**
     * Get fechaEmision
     *
     * @return \DateTime 
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
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
     * Set instrucciones
     *
     * @param string $instrucciones
     * @return Objeto
     */
    public function setInstrucciones($instrucciones)
    {
        $this->instrucciones = $instrucciones;
    
        return $this;
    }

    /**
     * Get instrucciones
     *
     * @return string 
     */
    public function getInstrucciones()
    {
        return $this->instrucciones;
    }
    
    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Objeto
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
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
     * @param Formato $padre
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
     * Add datosMercancias
     *
     * @param \PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercancias
     * @return Formato
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

    /**
     * Add condicion
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Condicion $condicion
     * @return Formato
     */
    public function addCondicion(\PuertoUDES\FormatosBundle\Entity\Condicion $condicion)
    {
        $this->condicion[] = $condicion;
    
        return $this;
    }

    /**
     * Remove condicion
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Condicion $condicion
     */
    public function removeCondicion(\PuertoUDES\FormatosBundle\Entity\Condicion $condicion)
    {
        $this->condicion->removeElement($condicion);
    }

    /**
     * Get condicion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCondiciones()
    {
        return $this->condicion;
    }
    
    public function getCondicionesPago(){
        if(empty($this->condicionesPago)){
            $this->loadCondicionesTipo();
        }
        return $this->condicionesPago;
    }
    
    public function getCondicionesTransporte(){
        if(empty($this->condicionesTransporte)){
            $this->loadCondicionesTipo();
        }
        return $this->condicionesTransporte;
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
    public function getUsuarios($tipo = '')
    {
        $usuarios = $this->usuarios;
        if(!empty($tipo)){
            $usuarios = array();
            foreach($this->usuarios as $u){
                if(strtolower($u->getRol()->getNombre()) == strtolower($tipo) || strtolower($u->getRol()->getCanonical()) == strtolower($tipo))
                    $usuarios[] = $u;
            }
        }
        return $usuarios;
    }

    /**
     * Get usuario
     * 
     * @param integer $id Iedentificador del usurio que busca
     * @return \PuertoUDES\FormatosBundle\Entity\FormatoUsuario
     */
    public function getUsuario($id = -1)
    {
        if($id >= 0){
            foreach($this->usuarios as $u){
                if($u->getUsuario()->getId() == $id)
                    return $u;
            }
        }
        return null;
    }

    /**
     * Get datosRecibe
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosRecibe()
    {
        if(empty($this->datosRecibe)){
            $this->loadDatosMercanciasTipo();
        }
        return $this->datosRecibe;
    }

    /**
     * Get datosEntrega
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosEntrega()
    {
        if(empty($this->datosEntrega)){
            $this->loadDatosMercanciasTipo();
        }
        return $this->datosEntrega;
    }
    /**
     * Get datosEmision
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosEmision()
    {
        if(empty($this->datosEmision)){
            $this->loadDatosMercanciasTipo();
        }
        return $this->datosEmision;
    }
    
    /**
     * Get gastosAPagarDestinatario
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosAPagarDestinatario()
    {
        if(empty($this->gastosAPagarDestinatario)){
            $this->loadGastos();
        }
        return $this->gastosAPagarDestinatario;
    }
    
    /**
     * Get existGastosAPagarDestinatario
     * 
     * @param string $concepto Concepto a revisar si está
     * @return \PuertoUDES\FormatosBundle\Entity\Gasto 
     */
    public function existGastosAPagarDestinatario($concepto)
    {
        $r = false;
        if(is_string($concepto)){
            $r = $this->getGastosAPagarDestinatario()->exists(function ($key, \PuertoUDES\FormatosBundle\Entity\Gasto $gasto) use ($concepto){
                return $gasto->getConcepto() == $concepto;
            });
        }
        return $r;
    }
    /**
     * Get gastosAPagarRemitente
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosAPagarRemitente()
    {
        if(empty($this->gastosAPagarRemitente)){
            $this->loadGastos();
        }
        return $this->gastosAPagarRemitente;
    }
    
    /**
     * Get existGastosAPagarRemitente
     * 
     * @param string $concepto Concepto a revisar si está
     * @return \PuertoUDES\FormatosBundle\Entity\Gasto 
     */
    public function existGastosAPagarRemitente($concepto)
    {
        $r = false;
        if(is_string($concepto)){
            $r = $this->getGastosAPagarRemitente()->exists(function ($key, \PuertoUDES\FormatosBundle\Entity\Gasto $gasto) use ($concepto){
                return $gasto->getConcepto() == $concepto;
            });
        }
        return $r;
    }
    /**
     * Get gastosMercancias
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastoMercancias()
    {
        if(count($this->gastoMercancias) <= 0){
            $this->loadGastos();
            $gm = $this->gastoMercancias;
            foreach ($this->getHijos() as $f) {
                $gm = new \Doctrine\Common\Collections\ArrayCollection(array_merge($gm->toArray(),$f->getGastoMercancias()->toArray()));
            }
            $this->gastoMercancias = $gm;
        }
        return $this->gastoMercancias;
    }
    
    /**
     * Get aduanasPartida
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanasPartida()
    {
        if(empty($this->aduanasPartida)){
            $this->loadAduanas();
        }
        return $this->aduanasPartida;
    }
    
    /**
     * Get aduanasCruce
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanasCruce()
    {
        if(empty($this->aduanasCruce) || is_null($this->aduanasCruce)){
            $this->loadAduanas();
        }
        return $this->aduanasCruce;
    }
    
    /**
     * Get aduanasDestino
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanasDestino()
    {
        if(empty($this->aduanasDestino)){
            $this->loadAduanas();
        }
        return $this->aduanasDestino;
    }
    
    /**
     * Get existGastoMercancias
     * 
     * @param string $concepto Concepto a revisar si está
     * @return \PuertoUDES\FormatosBundle\Entity\Gasto 
     */
    public function existGastoMercancias($concepto)
    {
        $r = false;
        if(is_string($concepto)){
            $r = $this->getGastoMercancias()->exists(function ($key, \PuertoUDES\FormatosBundle\Entity\Gasto $gasto) use ($concepto){
                return $gasto->getConcepto() == $concepto;
            });
        }
        return $r;
    }

    /**
     * Get datosEmbarque
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosEmbarque()
    {
        if(empty($this->datosEmbarque)){
            $this->loadDatosMercanciasTipo();
        }
        return $this->datosEmbarque;
    }
    /**
     * Get notificados
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotificados()
    {
        if(empty($this->notificados)){
            $this->loadUsuariosTipo();
        }
        return $this->notificados;
    }

    /**
     * Get remitentes
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRemitentes()
    {
        if(empty($this->remitentes)){
            $this->loadUsuariosTipo();
        }
        return $this->remitentes;
    }

    /**
     * Get destinatarios
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDestinatarios()
    {
        if(empty($this->destinatarios)){
            $this->loadUsuariosTipo();
        }
        return $this->destinatarios;
    }

    /**
     * Get consignatarios
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsignatarios()
    {
        if(empty($this->consignatarios)){
            $this->loadUsuariosTipo();
        }
        return $this->consignatarios;
    }
    /**
     * Get conductor
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Conductor
     */
    public function getConductor($auxiliar = false)
    {
        if(is_string($auxiliar)){
            if(strtolower($auxiliar) == 'auxiliar')
                $auxiliar = true;
            else
                $auxiliar = false;
        }
        foreach($this->conductores as $c)
            if(($c->getEsAuxiliar() && $auxiliar) || (!$c->getEsAuxiliar() && !$auxiliar))
                return $c->getConductor();
        return null;
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
     * Get gastos
     *
     * @param string $concepto Concepto a buscar en los gastos
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastoByConcepto($concepto, $rol=null)
    {
        foreach ($this->getGastos() as $g){
            if(     strtolower($g->getConcepto()->getNombre()) == strtolower($concepto) 
                ||  strtolower($g->getConcepto()->getCanonical()) == strtolower($concepto) 
                ||  strtolower($g->getConcepto()->getAbreviacion()) == strtolower($concepto)
            )
                if(is_null($rol))
                    return $g;
                elseif($g->getRolUsuario() && strtolower($g->getRolUsuario()->getNombre()) == strtolower($rol) 
                ||  strtolower($g->getRolUsuario()->getCanonical()) == strtolower($rol))
                    return $g;
        }
        return null;
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
    /**
     * Set incoterm
     *
     * @param \PuertoUDES\CommonBundle\Entity\Incoterm $incoterm
     * @return Formato
     */
    public function setIncoterm(\PuertoUDES\CommonBundle\Entity\Incoterm $incoterm)
    {
        $this->incoterm = $incoterm;
    
        return $this;
    }

    /**
     * Get incoterm
     *
     * @return \PuertoUDES\CommonBundle\Entity\Incoterm 
     */
    public function getIncoterm()
    {
        return $this->incoterm;
    }
    
    /**/
    public function getTotalPesoBruto(){
        if($this->totalPesoBruto == 0){
            $this->loadMedidas();
        }
        return $this->totalPesoBruto;
    }
    /**/
    public function getTotalPesoNeto(){
        if($this->totalPesoNeto == 0){
            $this->loadMedidas();
        }
        return $this->totalPesoNeto;
    }
    /**/
    public function getTotalVolumen(){
        if($this->totalVolumen == 0){
            $this->loadMedidas();
        }
        return $this->totalVolumen;
    }
    /**/
    public function getTotalVolumenOtro(){
        if($this->totalVolumenOtro == 0){
            $this->loadMedidas();
        }
        return $this->totalVolumenOtro;
    }
    /**/
    public function getGastoTotalRemitente(){
        if($this->gastoTotalRemitente == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalRemitente;
    }
    /**/
    public function getGastoTotalDestinatario(){
        if($this->gastoTotalDestinatario == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalDestinatario;
    }
    /**/
    public function getGastoTotalMercancias(){
        if($this->gastoTotalMercancias == 0){
            $this->loadGastos();
            $gastos = $this->gastoTotalMercancias;
            foreach ($this->getHijos() as $f) {
                $gastos += $f->getGastoTotalMercancias();
            }
            $this->gastoTotalMercancias = $gastos;
        }
        return $this->gastoTotalMercancias;
    }
    /**/
    public function getTipoMoneda(){
        $gm = $this->getGastoMercancias()->first();
        if($gm)
            return $gm->getMoneda();
        return null;
    }
    
    public function getContenedor(){
        if(!$this->getContenedoresMercancias()->isEmpty()){
            return $this->getContenedoresMercancias()->first()->getContenedor();
        }
        return null;
    }
    
    public function getContenedorHijos(){
        if(!$this->getHijos()->isEmpty()){
            foreach($this->getHijos() as $hijo){
                if(!is_null($hijo->getContenedor())){
                    return $hijo->getContenedor();
                }
            }
        }
        return null;
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

    private function loadUsuariosTipo() {
        $this->notificados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consignatarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->remitentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->destinatarios = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->usuarios as $u){
            switch(strtolower($u->getRol()->getNombre())){
                case 'notificado':
                    $this->notificados->add($u->getUsuario()->getEntidad());
                    break;
                case 'consignatario':
                    $this->consignatarios->add($u->getUsuario()->getEntidad());
                    break;
                case 'destinatario':
                    $this->destinatarios->add($u->getUsuario()->getEntidad());
                    break;
                case 'remitente':
                    $this->remitentes->add($u->getUsuario()->getEntidad());
                    break;
            }
        }
    }
    
    private function loadDatosMercanciasTipo() {
        $this->datosRecibe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEmision = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEmbarque = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEntrega = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->datosMercancias as $dm){
            switch(strtolower($dm->getTipo()->getCanonical())){
                case 'recibe':
                    $this->datosRecibe = $dm;
                    break;
                case 'embarque':
                    $this->datosEmbarque = $dm;
                    break;
                case 'entrega':
                    $this->datosEntrega = $dm;
                    break;
                case 'emision':
                    $this->datosEmision = $dm;
                    break;
            }
        }
    }
    
    private function loadCondicionesTipo() {
        $this->condicionesPago = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condicionesTransporte = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->condiciones as $dm){
            switch(strtolower($dm->getTipo()->getNombre())){
                case 'pago':
                    $this->condicionesPago = $dm;
                    break;
                case 'transporte':
                    $this->condicionesTransporte = $dm;
                    break;
            }
        }
    }
    
    private function loadGastos() {
        $this->gastosAPagarDestinatario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAPagarRemitente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastoMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastoTotalRemitente = 0;
        $this->gastoTotalDestinatario = 0;
        $this->gastoTotalMercancias = 0;
        foreach($this->gastos as $g){
            if(is_null($g->getRolUsuario())){
                $this->gastoMercancias->add($g);
                $this->gastoTotalMercancias += $g->getValor();
            }else{
                switch(strtolower($g->getRolUsuario()->getCanonical())){
                    case 'remitente':
                        $this->gastosAPagarRemitente->add($g);
                        $this->gastoTotalRemitente += $g->getValor();
                        break;
                    case 'destinatario':
                        $this->gastosAPagarDestinatario->add($g);
                        $this->gastoTotalDestinatario += $g->getValor();
                        break;
                }
            }
        }
//        var_dump('<pre>');
//        var_dump(count($this->gastoMercancias));
//        var_dump('</pre>');
//        var_dump(get_class($this->gastoMercancias[0]));
    }
    
    private function loadAduanas() {
        $this->aduanasCruce = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aduanasDestino = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aduanasPartida = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->aduanas as $a){
            if(strpos($a->getNivel()->getCanonical(), 'partida') !== false){
                    $this->aduanasPartida->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'cruce') !== false){
                    $this->aduanasCruce->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'destino') !== false){
                    $this->aduanasDestino->add($a);
            }
        }
    }
    
    private function loadMedidas(){
        $pesoBruto = 0;
        $pesoNeto = 0;
        $volumen = 0;
        $volumenOtro = 0;
        foreach ($this->getContenedoresMercancias() as $cm) {
            $pesoBruto += $cm->getPesoBruto();
            $pesoNeto += $cm->getPesoNeto();
            $volumen += $cm->getVolumen();
            $volumenOtro += $cm->getVolumenOtro();
        }
        foreach ($this->getHijos() as $f) {
            $pesoBruto += $f->getTotalPesoBruto();
            $pesoNeto += $f->getTotalPesoNeto();
            $volumen += $f->getTotalVolumen();
            $volumenOtro += $f->getTotalVolumenOtro();
        }
        $this->totalPesoBruto = $pesoBruto;
        $this->totalPesoNeto = $pesoNeto;
        $this->totalVolumen = $volumen;
        $this->totalVolumenOtro = $volumenOtro;
    }
}