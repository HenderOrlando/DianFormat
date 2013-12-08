<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="gasto")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\GastoRepository")
 */
class Gasto
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="gastos")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=true)
     */
    private $usuario;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Rol", inversedBy="gastos")
     * @ORM\JoinColumn(name="rol_usuario", referencedColumnName="id", nullable=true)
     */
    private $rolUsuario;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="gastos")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="valor", precision=10, scale=4)
     */
    private $valor;

    /** 
     * Conceptos básicos son: mercancia, valorFlete, seguro, suplementario, total
     * 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="gastos")
     * @ORM\JoinColumn(name="concepto", referencedColumnName="id", nullable=false)
     */
    private $concepto;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Moneda", inversedBy="gastos")
     * @ORM\JoinColumn(name="moneda", referencedColumnName="id", nullable=true)
     */
    private $moneda;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime();
        $this->valor = 0;
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Gasto
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set valor
     *
     * @param float $valor
     * @return Gasto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return float 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set concepto
     *
     * @param PuertoUDES\CommonBundle\Entity\Tipo $concepto
     * @return Gasto
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;
    
        return $this;
    }

    /**
     * Get concepto
     *
     * @return PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Gasto
     */
    public function setFechaCreado($fechaCreado)
    {
        $this->fechaCreado = $fechaCreado;
    
        return $this;
    }

    /**
     * Get fechaCreado
     *
     * @return \DateTime 
     */
    public function getFechaCreado()
    {
        return $this->fechaCreado;
    }

    /**
     * Set usuario
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuario
     * @return Gasto
     */
    public function setUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return Gasto
     */
    public function setFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formato)
    {
        $this->formato = $formato;
    
        return $this;
    }

    /**
     * Get formato
     *
     * @return \PuertoUDES\FormatosBundle\Entity\Formato 
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set moneda
     *
     * @param \PuertoUDES\CommonBundle\Entity\Moneda $moneda
     * @return Gasto
     */
    public function setMoneda(\PuertoUDES\CommonBundle\Entity\Moneda $moneda)
    {
        $this->moneda = $moneda;
    
        return $this;
    }

    /**
     * Get moneda
     *
     * @return \PuertoUDES\CommonBundle\Entity\Moneda 
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set rolUsuario
     *
     * @param \PuertoUDES\CommonBundle\Entity\Rol $rolUsuario
     * @return Gasto
     */
    public function setRolUsuario(\PuertoUDES\CommonBundle\Entity\Rol $rolUsuario)
    {
        $this->rolUsuario = $rolUsuario;
    
        return $this;
    }

    /**
     * Get rolUsuario
     *
     * @return \PuertoUDES\CommonBundle\Entity\Rol 
     */
    public function getRolUsuario()
    {
        return $this->rolUsuario;
    }
    
    public function json($json = true,
            $moneda = false,
            $formato = false,
            $rolUsuario = false,
            $usuario = false
            ){
        $a = array(
                'concepto'   =>  $this->getConcepto()->json(false),
                'valor'      =>  $this->getValor(),
                'moneda'     =>  $this->getMoneda()->getAbreviacion(),
            );
        if(is_bool($usuario) && $usuario){
            $a = array_merge($a, array( 
                'usuario'    =>  $this->getUsuario()->json(false),
            ));
        }
        if(is_bool($moneda) && $moneda){
            $a = array_merge($a, array( 
                'moneda'    =>  $this->getMoneda()->json(false),
            ));
        }
        if(is_bool($formato) && $formato){
            $a = array_merge($a, array( 
                'formato'    =>  $this->getUsuario()->json(false),
            ));
        }
        if(is_bool($rolUsuario) && $rolUsuario){
            $a = array_merge($a, array( 
                'rolUsuario' =>  $this->getRolUsuario()->json(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}