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
     */
    private $id;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="valor_flete")
     */
    private $valorFlete;

    /** 
     * @ORM\Column(type="decimal", nullable=false, name="otros_gastos")
     */
    private $otrosGastos;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="gastos")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="gastos")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime();
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
     * Set valorFlete
     *
     * @param float $valorFlete
     * @return Gasto
     */
    public function setValorFlete($valorFlete)
    {
        $this->valorFlete = $valorFlete;
    
        return $this;
    }

    /**
     * Get valorFlete
     *
     * @return float 
     */
    public function getValorFlete()
    {
        return $this->valorFlete;
    }

    /**
     * Set otrosGastos
     *
     * @param float $otrosGastos
     * @return Gasto
     */
    public function setOtrosGastos($otrosGastos)
    {
        $this->otrosGastos = $otrosGastos;
    
        return $this;
    }

    /**
     * Get otrosGastos
     *
     * @return float 
     */
    public function getOtrosGastos()
    {
        return $this->otrosGastos;
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
}