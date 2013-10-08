<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\MappedSuperclass
 * @ORM\Table(name="objeto_c")
 */
class ObjetoC
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="decimal", nullable=true, name="peso_bruto", precision=4, scale=2)
     */
    private $pesoBruto;

    /** 
     * @ORM\Column(type="decimal", nullable=true, name="peso_neto", precision=4, scale=2)
     */
    private $pesoNeto;

    /** 
     * @ORM\Column(type="decimal", nullable=true, precision=4, scale=2)
     */
    private $volumen;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $fechaCreado;
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
     * Set pesoBruto
     *
     * @param float $pesoBruto
     * @return ObjetoC
     */
    public function setPesoBruto($pesoBruto)
    {
        $this->pesoBruto = $pesoBruto;
    
        return $this;
    }

    /**
     * Get pesoBruto
     *
     * @return float 
     */
    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    /**
     * Set pesoNeto
     *
     * @param float $pesoNeto
     * @return ObjetoC
     */
    public function setPesoNeto($pesoNeto)
    {
        $this->pesoNeto = $pesoNeto;
    
        return $this;
    }

    /**
     * Get pesoNeto
     *
     * @return float 
     */
    public function getPesoNeto()
    {
        return $this->pesoNeto;
    }

    /**
     * Set volumen
     *
     * @param float $volumen
     * @return ObjetoC
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;
    
        return $this;
    }

    /**
     * Get volumen
     *
     * @return float 
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return ObjetoC
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
}