<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="formato_conductor")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\FormatoConductorRepository")
 */
class FormatoConductor
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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="conductores")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Conductor", inversedBy="formatos")
     * @ORM\JoinColumn(name="conductor", referencedColumnName="id", nullable=false)
     */
    private $conductor;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Vehiculo", inversedBy="formatos")
     * @ORM\JoinColumn(name="vehiculo", referencedColumnName="id", nullable=false)
     */
    private $vehiculo;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime();
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
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return FormatoConductor
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
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return FormatoConductor
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
     * Set conductor
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Conductor $conductor
     * @return FormatoConductor
     */
    public function setConductor(\PuertoUDES\UsuariosBundle\Entity\Conductor $conductor)
    {
        $this->conductor = $conductor;
    
        return $this;
    }

    /**
     * Get conductor
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Conductor 
     */
    public function getConductor()
    {
        return $this->conductor;
    }

    /**
     * Set vehiculo
     *
     * @param \PuertoUDES\CommonBundle\Entity\Vehiculo $vehiculo
     * @return FormatoConductor
     */
    public function setVehiculo(\PuertoUDES\CommonBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculo = $vehiculo;
    
        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \PuertoUDES\CommonBundle\Entity\Vehiculo 
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}