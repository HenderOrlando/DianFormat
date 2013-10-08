<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="formato_aduana")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\FormatoAduanaRepository")
 */
class FormatoAduana
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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Aduana", inversedBy="fomatos")
     * @ORM\JoinColumn(name="aduana", referencedColumnName="id", nullable=false)
     */
    private $aduana;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="aduanas")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="formatoAduanas")
     * @ORM\JoinColumn(name="nivel", referencedColumnName="id", nullable=false)
     */
    private $nivel;
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
     * @return FormatoAduana
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
     * Set aduana
     *
     * @param \PuertoUDES\CommonBundle\Entity\Aduana $aduana
     * @return FormatoAduana
     */
    public function setAduana(\PuertoUDES\CommonBundle\Entity\Aduana $aduana)
    {
        $this->aduana = $aduana;
    
        return $this;
    }

    /**
     * Get aduana
     *
     * @return \PuertoUDES\CommonBundle\Entity\Aduana 
     */
    public function getAduana()
    {
        return $this->aduana;
    }

    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return FormatoAduana
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
     * Set nivel
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $nivel
     * @return FormatoAduana
     */
    public function setNivel(\PuertoUDES\CommonBundle\Entity\Tipo $nivel)
    {
        $this->nivel = $nivel;
    
        return $this;
    }

    /**
     * Get nivel
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getNivel()
    {
        return $this->nivel;
    }
}