<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
     * @ORM\Column(type="string", length=40, nullable=false, name="numero")
     */
    private $numero;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="codAcuerdo")
     */
    private $codAcuerdo;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="subpartidaArancelaria")
     */
    private $subpartidaArancelaria;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="codigoComplementario")
     */
    private $codigoComplementario;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="codigoSuplementario")
     */
    private $codigoSuplementario;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="codModalidad")
     */
    private $codModalidad;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="numeroCuotas")
     */
    private $numeroCuotas;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="valorCuotas")
     */
    private $valorCuotas;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="periodoCuotas")
     */
    private $periodoCuotas;

    /** 
     * @ORM\Column(type="string", length=140, nullable=false, name="formasPago")
     */
    private $formaPago;

    /** 
     * @ORM\Column(type="string", length=140, nullable=false, name="tipoImportacion")
     */
    private $tipoImportacion;

    /** 
     * @ORM\Column(type="float", nullable=true, name="tasaCambio")
     */
    private $tasaCambio;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="numeroPrograma")
     */
    private $numeroPrograma;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="numeroAprobacion")
     */
    private $numeroAprobacion;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="codRegistroLic")
     */
    private $codRegistroLic;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="codOficina")
     */
    private $codOficina;

    /** 
     * @ORM\Column(type="float", nullable=false, name="valorPagosAnteriores")
     */
    private $valorPagosAnteriores;

    /** 
     * @ORM\Column(type="string", length=40, nullable=false, name="numeroReciboPagoAnterior")
     */
    private $numeroReciboPagoAnterior;

    /** 
     * @ORM\Column(type="string", length=10, nullable=true, name="modoTransporte")
     */
    private $modoTransporte;

    /** 
     * @ORM\Column(type="string", length=40, nullable=true, name="levante")
     */
    private $levante;

    /** 
     * @ORM\Column(type="string", length=40, nullable=true, name="aceptacion")
     */
    private $aceptacion;

    /** 
     * @ORM\Column(type="integer", nullable=true, name="flete")
     */
    private $flete;
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\CommonBundle\Entity\Documento", mappedBy="formato")
     */
    private $documentos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoConductor", mappedBy="formato")
     */
    private $conductores;
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="porConducto")
     */
    private $porConducto;
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="instrucciones")
     */
    private $instrucciones;
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="observaciones")
     */
    private $observaciones;
    
    /** 
     * @ORM\OneToMany(targetEntity="\PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="formato", cascade={"all"})
     */
    private $usuarios;
    
    /** 
     * @ORM\ManyToOne(targetEntity="\PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="formatos_autor")
     * @ORM\JoinColumn(name="autor", referencedColumnName="id", nullable=true)
     */
    private $autor;
    
    private $exportadores;
    private $importadores;
    private $notificados;
    private $consignatarios;
    private $remitentes;
    private $destinatarios;
    private $declarantes;
    private $transportistas;
    private $clientes;
    private $empresas;

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
    private $aduanasDeclaracion;
    private $aduanasExportacion;

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
    private $gastosAPagar;
    private $gastosFletes;
    private $gastosAduana;
    private $gastosFob;
    private $gastosOtros;
    private $gastosAjuste;
    private $gastosSeguros;
    private $gastosAPagarRemitente;
    private $gastosAPagarDestinatario;
    private $gastoContenedoresMercancias;

    /**
     * @ORM\ManyToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato")
     * @ORM\JoinTable(name="formatosHermanos",
     *      joinColumns={@ORM\JoinColumn(name="formato_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="hermano_id", referencedColumnName="id")}
     *  )
     */
    private $hermanos;

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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="declaraciones")
     * @ORM\JoinColumn(name="tipoDeclaracion", referencedColumnName="id", nullable=true)
     */
    private $tipoDeclaracion;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="formatos")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=true)
     */
    private $pais;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="formatosCompra")
     * @ORM\JoinColumn(name="paisCompra", referencedColumnName="id", nullable=true)
     */
    private $paisCompra;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="formatosOrigen")
     * @ORM\JoinColumn(name="paisOrigen", referencedColumnName="id", nullable=true)
     */
    private $paisOrigen;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="formatosBandera")
     * @ORM\JoinColumn(name="paisBandera", referencedColumnName="id", nullable=true)
     */
    private $paisBandera;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Incoterm", inversedBy="formatos")
     * @ORM\JoinColumn(name="incoterm", referencedColumnName="id", nullable=true)
     */
    private $incoterm;
    
    private $totalPesoBruto;
    private $totalPesoNeto;
    private $totalVolumen;
    private $totalVolumenOtro;
    
    private $gastoTotal;
    private $gastoTotalRemitente;
    private $gastoTotalMercancias;
    private $gastoTotalDestinatario;
    
    private $gastoTotalFob;
    private $gastoTotalFletes;
    private $gastoTotalAjuste;
    private $gastoTotalSeguros;
    private $gastoTotalAduana;
    private $gastoTotalOtros;
    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_emision")
     */
    private $fechaEmision;
    
    /** 
     * @ORM\Column(type="date", nullable=true, name="fecha_llegada")
     */
    private $fechaLlegada;
    
    /** 
     * @ORM\Column(type="date", nullable=true, name="fecha_levante")
     */
    private $fechaLevante;
    
    /** 
     * @ORM\Column(type="date", nullable=true, name="fecha_aceptacion")
     */
    private $fechaAceptacion;
    
    /** 
     * @ORM\Column(type="date", nullable=true, name="fecha_recibo_pago_anterior")
     */
    private $fechaReciboPagoAnterior;
    
    /** 
     * @ORM\Column(type="date", nullable=true, name="fecha_licencia_exportacion")
     */
    private $fechaLicenciaExportacion;
    
    /** 
     * @ORM\Column(type="string", length=5,  nullable=true, name="cod_deposito")
     */
    private $codDeposito;
    
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
        $this->declarantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exportadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->transportistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->condiciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hermanos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->totalPesoBruto = $this->totalPesoNeto = $this->totalVolumen = $this->totalVolumenOtro = $this->gastoTotalDestinatario = $this->gastoTotal = $this->gastoTotalRemitente = $this->gastoTotalMercancias = 0;
    }
    
    public function getFullNombre(){
        return 'No. '.$this->getNumero().' - '.$this->getNombre();
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
    public function getFechaEmision($format = null)
    {
        $fecha = $this->fechaEmision;
        if($fecha && !is_null($format)){
            $fecha = $fecha->format($format);
        }
        return $fecha;
    }
    
    /**
     * Set fechaLicenciaExportacion
     *
     * @param \DateTime $fechaLicenciaExportacion
     * @return Objeto
     */
    public function setFechaLicenciaExportacion($fechaLicenciaExportacion)
    {
        $this->fechaLicenciaExportacion = $fechaLicenciaExportacion;
    
        return $this;
    }

    /**
     * Get fechaLicenciaExportacion
     *
     * @return \DateTime 
     */
    public function getFechaLicenciaExportacion($format = null)
    {
        $fecha = $this->fechaLicenciaExportacion;
        if($fecha && !is_null($format)){
            $fecha = $fecha->format($format);
        }
        return $fecha;
    }
    
    /**
     * Set fechaLlegada
     *
     * @param \DateTime $fechaLlegada
     * @return Objeto
     */
    public function setFechaLlegada($fechaLlegada)
    {
        $this->fechaLlegada = $fechaLlegada;
    
        return $this;
    }

    /**
     * Get fechaLlegada
     *
     * @return \DateTime 
     */
    public function getFechaLlegada($format = null)
    {
        $fecha = $this->fechaLlegada;
        if($fecha && !is_null($format)){
            return $fecha->format($format);
        }
        return $this->fechaLlegada;
    }
    
    /**
     * Set fechaPagoAnterior
     *
     * @param \DateTime $fechaPagoAnterior
     * @return Objeto
     */
    public function setFechaReciboPagoAnterior($fechaReciboPagoAnterior)
    {
        $this->fechaReciboPagoAnterior = $fechaReciboPagoAnterior;
    
        return $this;
    }

    /**
     * Get fechaReciboPagoAnterior
     *
     * @return \DateTime 
     */
    public function getFechaReciboPagoAnterior($format = null)
    {
        $fecha = $this->fechaReciboPagoAnterior;
        if($fecha && !is_null($format)){
            return $fecha->format($format);
        }
        return $this->fechaReciboPagoAnterior;
    }
    
    /**
     * Set fechaAceptacion
     *
     * @param \DateTime $fechaAceptacion
     * @return Objeto
     */
    public function setFechaAceptacion($fechaAceptacion)
    {
        $this->fechaAceptacion = $fechaAceptacion;
    
        return $this;
    }

    /**
     * Get fechaAceptacion
     *
     * @return \DateTime 
     */
    public function getFechaAceptacion($format = null)
    {
        $fecha = $this->fechaAceptacion;
        if($fecha && !is_null($format)){
            return $fecha->format($format);
        }
        return $this->fechaAceptacion;
    }
    
    /**
     * Set fechaLevante
     *
     * @param \DateTime $fechaLevante
     * @return Objeto
     */
    public function setFechaLevante($fechaLevante)
    {
        $this->fechaLevante = $fechaLevante;
    
        return $this;
    }

    /**
     * Get fechaLevante
     *
     * @return \DateTime 
     */
    public function getFechaLevante($format = null)
    {
        $fecha = $this->fechaLevante;
        if($fecha && !is_null($format)){
            return $fecha->format($format);
        }
        return $this->fechaLevante;
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
     * Set porConducto
     *
     * @param string $porConducto
     * @return Objeto
     */
    public function setPorConducto($porConducto)
    {
        $this->porConducto = $porConducto;
    
        return $this;
    }

    /**
     * Get porConducto
     *
     * @return string 
     */
    public function getPorConducto()
    {
        return $this->porConducto;
    }
    
    /**
     * Set Autor
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $autor
     * @return Objeto
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    
        return $this;
    }

    /**
     * Get autor
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Usuario
     */
    public function getAutor()
    {
        return $this->autor;
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
     * Get codOficina
     *
     * @return integer
     */
    public function getCodOficina()
    {
        return $this->codOficina;
    }
    
    /**
     * Set codOficina
     *
     * @param integer $codOficina
     * @return Formato
     */
    public function setCodOficina($codOficina)
    {
        $this->codOficina = $codOficina;
        return $this;
    }
    
    /**
     * Get codRegistroLic
     *
     * @return integer
     */
    public function getCodRegistroLic()
    {
        return $this->codRegistroLic;
    }
    
    /**
     * Set codRegistroLic
     *
     * @param integer $codRegistroLic
     * @return Formato
     */
    public function setCodRegistroLic($codRegistroLic)
    {
        $this->codRegistroLic = $codRegistroLic;
        return $this;
    }
    
    /**
     * Get numeroAprobacion
     *
     * @return integer
     */
    public function getNumeroAprobacion()
    {
        return $this->numeroAprobacion;
    }
    
    /**
     * Set numeroAprobacion
     *
     * @param integer $numeroAprobacion
     * @return Formato
     */
    public function setNumeroAprobacion($numeroAprobacion)
    {
        $this->numeroAprobacion = $numeroAprobacion;
        return $this;
    }
    
    /**
     * Get numeroPrograma
     *
     * @return integer
     */
    public function getNumeroPrograma()
    {
        return $this->numeroPrograma;
    }
    
    /**
     * Set numeroPrograma
     *
     * @param integer $numeroPrograma
     * @return Formato
     */
    public function setNumeroPrograma($numeroPrograma)
    {
        $this->numeroPrograma = $numeroPrograma;
        return $this;
    }
    
    /**
     * Get valorCuota
     *
     * @return integer
     */
    public function getCodAcuerdo()
    {
        return $this->codAcuerdo;
    }
    
    /**
     * Set valorCuota
     *
     * @param integer $valorCuota
     * @return Formato
     */
    public function setCodAcuerdo($valorCuotas)
    {
        $this->codAcuerdo = $valorCuotas;
        return $this;
    }
    
    /**
     * Get valorCuota
     *
     * @return integer
     */
    public function getPeriodoCuotas()
    {
        return $this->periodoCuotas;
    }
    
    /**
     * Set valorCuota
     *
     * @param integer $valorCuota
     * @return Formato
     */
    public function setPeriodoCuotas($valorCuotas)
    {
        $this->periodoCuotas = $valorCuotas;
        return $this;
    }
    
    /**
     * Get valorCuota
     *
     * @return integer
     */
    public function getValorCuotas()
    {
        return $this->valorCuotas;
    }
    
    /**
     * Set valorCuota
     *
     * @param integer $valorCuota
     * @return Formato
     */
    public function setValorCuotas($valorCuotas)
    {
        $this->valorCuotas = $valorCuotas;
        return $this;
    }
    
    /**
     * Get numeroCuotas
     *
     * @return integer
     */
    public function getNumeroCuotas()
    {
        return $this->numeroCuotas;
    }
    
    /**
     * Set numeroCuotas
     *
     * @param integer $numeroCuotas
     * @return Formato
     */
    public function setNumeroCuotas($numeroCuotas)
    {
        $this->numeroCuotas = $numeroCuotas;
        return $this;
    }
    
    /**
     * Get codModalidad
     *
     * @return integer
     */
    public function getCodModalidad()
    {
        return $this->codModalidad;
    }
    
    /**
     * Set codModalidad
     *
     * @param integer $codModalidad
     * @return Formato
     */
    public function setCodModalidad($codModalidad)
    {
        $this->codModalidad = $codModalidad;
        return $this;
    }
    
    /**
     * Get codigoSuplementario
     *
     * @return integer
     */
    public function getCodigoSuplementario()
    {
        return $this->codigoSuplementario;
    }
    
    /**
     * Set codigoSuplementario
     *
     * @param integer $codigoSuplementario
     * @return Formato
     */
    public function setCodigoSuplementario($codigoSuplementario)
    {
        $this->codigoSuplementario = $codigoSuplementario;
        return $this;
    }
    
    /**
     * Get codigoComplementario
     *
     * @return integer
     */
    public function getCodigoComplementario()
    {
        return $this->codigoComplementario;
    }
    
    /**
     * Set codigoComplementario
     *
     * @param integer $codigoComplementario
     * @return Formato
     */
    public function setCodigoComplementario($codigoComplementario)
    {
        $this->codigoComplementario = $codigoComplementario;
        return $this;
    }
    
    /**
     * Get subpartidaArancelaria
     *
     * @return integer
     */
    public function getSubpartidaArancelaria()
    {
        return $this->subpartidaArancelaria;
    }
    
    /**
     * Set subpartidaArancelaria
     *
     * @param integer $subpartidaArancelaria
     * @return Formato
     */
    public function setSubpartidaArancelaria($subpartidaArancelaria)
    {
        $this->subpartidaArancelaria = $subpartidaArancelaria;
        return $this;
    }
    
    /**
     * Get tipoImportacion
     *
     * @return integer
     */
    public function getTipoImportacion()
    {
        return $this->tipoImportacion;
    }
    
    /**
     * Set tipoImportacion
     *
     * @param integer $tipoImportacion
     * @return Formato
     */
    public function setTipoImportacion($tipoImportacion)
    {
        $this->tipoImportacion = $tipoImportacion;
        return $this;
    }
    
    /**
     * Get formaPago
     *
     * @return integer
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }
    
    /**
     * Set formaPago
     *
     * @param integer $formaPago
     * @return Formato
     */
    public function setFormaPago($formaPago)
    {
        $this->formaPago = $formaPago;
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
     * Get numeroRecivoPagoAnterior
     *
     * @return integer
     */
    public function getNumeroReciboPagoAnterior()
    {
        return $this->numeroReciboPagoAnterior;
    }
    
    /**
     * Set numeroRecivoPagoAnterior
     *
     * @param integer $numeroRecivoPagoAnterior
     * @return Formato
     */
    public function setNumeroReciboPagoAnterior($numeroRecivoPagoAnterior)
    {
        $this->numeroReciboPagoAnterior = $numeroRecivoPagoAnterior;
        return $this;
    }
    
    /**
     * Get numeroRecivoPagoAnterior
     *
     * @return integer
     */
    public function getValorPagosAnteriores()
    {
        return $this->valorPagosAnteriores;
    }
    
    /**
     * Set numeroRecivoPagoAnterior
     *
     * @param integer $numeroRecivoPagoAnterior
     * @return Formato
     */
    public function setValorPagosAnteriores($numeroRecivoPagoAnterior)
    {
        $this->valorPagosAnteriores = $numeroRecivoPagoAnterior;
        return $this;
    }
    
    /**
     * Get tasaCambio
     *
     * @return integer
     */
    public function getTasaCambio()
    {
        return $this->tasaCambio;
    }
    
    /**
     * Set tasaCambio
     *
     * @param integer $tasaCambio
     * @return Formato
     */
    public function setTasaCambio($tasaCambio)
    {
        $this->tasaCambio = $tasaCambio;
        return $this;
    }
    
    /**
     * Get modoTransporte
     *
     * @return string
     */
    public function getModoTransporte()
    {
        return $this->modoTransporte;
    }
    
    /**
     * Set modoTransporte
     *
     * @param string $modoTransporte
     * @return Formato
     */
    public function setModoTransporte($modoTransporte)
    {
        $this->modoTransporte = $modoTransporte;
        return $this;
    }
    
    /**
     * Get aceptacion
     *
     * @return string
     */
    public function getAceptacion()
    {
        return $this->aceptacion;
    }
    
    /**
     * Set aceptacion
     *
     * @param string $aceptacion
     * @return Formato
     */
    public function setAceptacion($aceptacion)
    {
        $this->aceptacion = $aceptacion;
        return $this;
    }
    
    /**
     * Get levante
     *
     * @return string
     */
    public function getLevante()
    {
        return $this->levante;
    }
    
    /**
     * Set levante
     *
     * @param string $levante
     * @return Formato
     */
    public function setLevante($levante)
    {
        $this->levante = $levante;
        return $this;
    }
    
    /**
     * Get codDeposito
     *
     * @return integer
     */
    public function getCodDeposito()
    {
        return $this->codDeposito;
    }
    
    /**
     * Set codDeposito
     *
     * @param integer $codDeposito
     * @return Formato
     */
    public function setCodDeposito($codDeposito)
    {
        $this->codDeposito = $codDeposito;
        return $this;
    }
    
    /**
     * Get flete
     *
     * @return integer
     */
    public function getFlete()
    {
        return $this->flete;
    }
    
    /**
     * Set flete
     *
     * @param integer $flete
     * @return Formato
     */
    public function setFlete($flete)
    {
        $this->flete = $flete;
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
     * Get gastosOtros
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosOtros()
    {
        if(empty($this->gastosOtros)){
            $this->loadGastos();
        }
        return $this->gastosOtros;
    }
    /**
     * Get gastosSeguros
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosSeguros()
    {
        if(empty($this->gastosSeguros)){
            $this->loadGastos();
        }
        return $this->gastosSeguros;
    }
    /**
     * Get gastosFletes
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosFletes()
    {
        if(empty($this->gastosFletes)){
            $this->loadGastos();
        }
        return $this->gastosFletes;
    }
    /**
     * Get gastosFletes
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosFob()
    {
        if(empty($this->gastosFob)){
            $this->loadGastos();
        }
        return $this->gastosFob;
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
     * Get gastosAPagar
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastosAPagar()
    {
        if(empty($this->gastosAPagar)){
            $this->loadGastos();
        }
        return $this->gastosAPagar;
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
     * Get gastosContenedoresMercancias
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastoContenedoresMercancias()
    {
        if(count($this->gastoContenedoresMercancias) <= 0){
            $this->loadGastos();
        }
        return $this->gastoContenedoresMercancias;
    }
    /**
     * Get getGastoContenedoresMercancia
     * 
     * @return \PuertoUDES\FormatosBundle\Entity\Gasto
     */
    public function getGastoContenedorMercancia(\PuertoUDES\CommonBundle\Entity\Mercancia $mercancia)
    {
        foreach($this->getGastoContenedoresMercancias() as $g){
            if(!is_null($g->getMercancia()) && $g->getMercancia()->getId() == $mercancia->getId()){
                return $g;
            }
        }
        return null;
    }
    /**
     * Get getGastoContenedoresMercancia
     * 
     * @return \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato
     */
    public function getContenedorMercancia(\PuertoUDES\CommonBundle\Entity\Mercancia $mercancia)
    {
        foreach($this->getContenedoresMercancias() as $c){
            if(!is_null($c->getMercancia()) && $c->getMercancia()->getId() == $mercancia->getId()){
                return $c;
            }
        }
        return null;
    }
    
    /**
     * Get aduanasDeclaracion
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanasDeclaracion()
    {
        if(empty($this->aduanasDeclaracion)){
            $this->loadAduanas();
        }
        return $this->aduanasDeclaracion;
    }
    
    /**
     * Get aduanasExportacion
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanasExportacion()
    {
        if(empty($this->aduanasExportacion)){
            $this->loadAduanas();
        }
        return $this->aduanasExportacion;
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
     * Get transportistas
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransportistas()
    {
        if(empty($this->transportistas)){
            $this->loadUsuariosTipo();
        }
        return $this->transportistas;
    }

    /**
     * Get empresas
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmpresas()
    {
        if(empty($this->empresas)){
            $this->loadUsuariosTipo();
        }
        return $this->empresas;
    }

    /**
     * Get clientes
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClientes()
    {
        if(empty($this->clientes)){
            $this->loadUsuariosTipo();
        }
        return $this->clientes;
    }
    
    /**
     * Get declarantes
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDeclarantes()
    {
        if(empty($this->declarantes)){
            $this->loadUsuariosTipo();
        }
        return $this->declarantes;
    }
    
    /**
     * Get importadores
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImportadores()
    {
        if(empty($this->importadores)){
            $this->loadUsuariosTipo();
        }
        return $this->importadores;
    }
    
    /**
     * Get exportadores
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExportadores()
    {
        if(empty($this->exportadores)){
            $this->loadUsuariosTipo();
        }
        return $this->exportadores;
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
            if(strtolower($auxiliar) == 'auxiliar'){
                $auxiliar = true;
            }
            else{
                $auxiliar = false;
            }
        }
        foreach($this->conductores as $c){
            if(($c->getEsAuxiliar() && $auxiliar) || (!$c->getEsAuxiliar() && !$auxiliar)){
                return $c->getConductor();
            }
        }
        return null;
    }
    
    /**
     * Add hermanos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $hermanos
     * @return Formato
     */
    public function addHermano(\PuertoUDES\FormatosBundle\Entity\Formato $hermanos)
    {
        $this->hermanos[] = $hermanos;
    
        return $this;
    }

    /**
     * Remove hermanos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $hermanos
     */
    public function removeHermano(\PuertoUDES\FormatosBundle\Entity\Formato $hermanos)
    {
        $this->hermanos->removeElement($hermanos);
    }

    /**
     * Get hermanos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHermanos()
    {
        return $this->hermanos;
    }

    /**
     * Get hermano
     * 
     * @param type $tipo    String del tipo de hermano a buscar
     * @param type $len     Número de hermanos a retornar en caso de encontrar más de 1
     * @param type $id      Id del hermano a retornar
     * 
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHermano($tipo, $id = -1, $len = 1)
    {
        $tipo = strtolower($tipo);
        $count = 0;
        $a = $this->getHermanos()->filter(function(Formato $hermano) use ($tipo, $id, $count, $len){
            $id_ = true;
            if($id >= 0){
                $id_ = $hermano->getId() === $id;
            }
            if($hermano->getTipo()->getAbreviacion() === $tipo && $id_){
                $count++;
            }
            return $hermano->getTipo()->getAbreviacion() === $tipo && $id_;
        });
        $hermano = null;
        if($a->count() > 1){
            $hermano = $a;
        }elseif($a->count() === 1){
            $hermano = $a->first();
        }
        return $hermano;
    }
        
    /**
     * Add hijos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $hijo
     * @return Formato
     */
    public function addHijo(\PuertoUDES\FormatosBundle\Entity\Formato $hijo)
    {
        $this->hijos[] = $hijo;
    
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
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return Formato
     */
    public function setPais(\PuertoUDES\CommonBundle\Entity\Pais $pais)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set paisCompra
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $paisCompra
     * @return Formato
     */
    public function setPaisCompra(\PuertoUDES\CommonBundle\Entity\Pais $paisCompra)
    {
        $this->paisCompra = $paisCompra;
    
        return $this;
    }

    /**
     * Get paisCompra
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais
     */
    public function getPaisCompra()
    {
        return $this->paisCompra;
    }

    /**
     * Set paisBandera
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $paisBandera
     * @return Formato
     */
    public function setPaisBandera(\PuertoUDES\CommonBundle\Entity\Pais $paisBandera)
    {
        $this->paisBandera = $paisBandera;
    
        return $this;
    }

    /**
     * Get paisBandera
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais
     */
    public function getPaisBandera()
    {
        return $this->paisBandera;
    }

    /**
     * Set paisOrigen
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $paisOrigen
     * @return Formato
     */
    public function setPaisOrigen(\PuertoUDES\CommonBundle\Entity\Pais $paisOrigen)
    {
        $this->paisOrigen = $paisOrigen;
    
        return $this;
    }

    /**
     * Get paisOrigen
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais
     */
    public function getPaisOrigen()
    {
        return $this->paisOrigen;
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
     * Set tipoDeclaracion
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $tipoDeclaracion
     * @return Formato
     */
    public function setTipoDeclaracion(\PuertoUDES\CommonBundle\Entity\Tipo $tipoDeclaracion)
    {
        $this->tipoDeclaracion = $tipoDeclaracion;
    
        return $this;
    }

    /**
     * Get tipoDeclaracion
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getTipoDeclaracion()
    {
        return $this->tipoDeclaracion;
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
    public function getTotalGastosOtros(){
        if($this->gastoTotalOtros == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalOtros;
    }
    /**/
    public function getTotalGastosAduana(){
        if($this->gastoTotalAduana == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalAduana;
    }
    /**/
    public function getTotalGastosFletes(){
        if($this->gastoTotalFletes == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalFletes;
    }
    /**/
    public function getTotalGastosAjuste(){
        if($this->gastoTotalAjuste == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalAjuste;
    }
    /**/
    public function getTotalGastosFob(){
        if($this->gastoTotalFob == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalFob;
    }
    /**/
    public function getTotalGastosSeguros(){
        if($this->gastoTotalSeguros == 0){
            $this->loadGastos();
        }
        return $this->gastoTotalSeguros;
    }
    /**/
    public function getGastoTotal(){
        if($this->gastoTotal == 0){
            $this->loadGastos();
        }
        return $this->gastoTotal;
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
            $tipo = false,
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
                'transportista' =>  method_exists($this->getTransportista(), 'json')?$this->getTransportista()->json(false):null,
                'numero'        =>  $this->getNumero(),
                'completo'      =>  $this->getCompleto(),
                'fullNombre'    =>  $this->getFullNombre(),
                'fechaEmision'  =>  $this->getFechaEmision('Y m d')
            )
        );
        if(is_bool($tipo) && $tipo){
            $a = array_merge($a, array(
                'tipo' => $this->getTipo()->json(false)
            ));
        }
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
    
    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE)
            .'\\'.$this->getNumero()
            .'\\'.$this->getObservaciones();
        if($this->getTipo()){
            $a .= '\\'.$this->getTipo()->getTokens(false);
        }
        if($this->getAutor()){
            $a .= '\\'.$this->getAutor()->getTokens(false);
        }
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }

    private function loadUsuariosTipo() {
        $this->notificados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consignatarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->remitentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->destinatarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->declarantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exportadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->transportistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
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
                case 'declarante':
                    $this->declarantes->add($u->getUsuario()->getEntidad());
                    break;
                case 'importador':
                    $this->importadores->add($u->getUsuario()->getEntidad());
                    break;
                case 'exportador':
                    $this->exportadores->add($u->getUsuario()->getEntidad());
                    break;
                case 'transportista':
                    $this->transportistas->add($u->getUsuario()->getEntidad());
                    break;
                case 'cliente':
                    $this->clientes->add($u->getUsuario()->getEntidad());
                    break;
                case 'empresa':
                    $this->empresas->add($u->getUsuario()->getEntidad());
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
        $this->gastoContenedoresMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAPagarDestinatario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAPagarRemitente = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastoMercancias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosSeguros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAPagar = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosFletes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAduana = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosAjuste = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastosOtros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastoTotal = $this->gastoTotalFletes = $this->gastoTotalSeguros = $this->gastoTotalOtros = $this->gastoTotalFob = $this->gastoTotalAduana = $this->gastoTotalRemitente = $this->gastoTotalDestinatario = $this->gastoTotalMercancias = 0;
        $this->gastosFob = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->gastos as $g){
            if(!is_null($g->getMercancia())){
                $this->gastosAPagar->add($g);
                $this->gastoContenedoresMercancias->add($g);
                $cm = $this->getContenedorMercancia($g->getMercancia());
                if($cm){
                    $this->gastoTotal += ($g->getValor() * $cm->getNumBultos());
                }
            }elseif(is_null($g->getRolUsuario())){
                $this->gastoMercancias->add($g);
                $this->gastoTotalMercancias += $g->getValor();
                switch ($g->getConcepto()->getCanonical()) {
                    case 'valor-del-flete':
                        $this->gastosFletes->add($g);
                        $this->gastoTotalFletes += $g->getValor();
                        break;
                    case 'seguro':
                        $this->gastosSeguros->add($g);
                        $this->gastoTotalSeguros += $g->getValor();
                        break;
                    case 'otros-gastos-suplementarios':
                        $this->gastosOtros->add($g);
                        $this->gastoTotalOtros += $g->getValor();
                        break;
                    case 'fob':
                        $this->gastosFob->add($g);
                        $this->gastoTotalFob+= $g->getValor();
                        break;
                    case 'ajuste':
                        $this->gastosAjuste->add($g);
                        $this->gastoTotalAjuste+= $g->getValor();
                        break;
                    case 'aduana':
                        $this->gastosAduana->add($g);
                        $this->gastoTotalAduana+= $g->getValor();
                        break;
                    default:
                        break;
                }
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
                    default:
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
        $this->aduanasDeclaracion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->aduanasExportacion = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->aduanas as $a){
            if(strpos($a->getNivel()->getCanonical(), 'partida') !== false){
                    $this->aduanasPartida->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'cruce') !== false){
                    $this->aduanasCruce->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'destino') !== false){
                    $this->aduanasDestino->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'declaracion') !== false){
                    $this->aduanasDeclaracion->add($a);
            }elseif(strpos($a->getNivel()->getCanonical(), 'exportacion') !== false){
                    $this->aduanasExportacion->add($a);
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
    
    public static function loadValidatorMetadata(\Symfony\Component\Validator\Mapping\ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(array(
            'fields'  => [
                'numero',
                'tipo',
            ],
            'message' => 'Ya existe un Formato con el mismo número.',
        )));
    }
}