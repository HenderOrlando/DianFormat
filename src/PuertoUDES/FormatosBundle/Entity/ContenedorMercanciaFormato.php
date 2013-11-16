<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="contenedor_mercancia_formato")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\ContenedorMercanciaFormatoRepository")
 */
class ContenedorMercanciaFormato extends \PuertoUDES\CommonBundle\Entity\ObjetoC
{
    /** 
     * @ORM\Column(nullable=true, name="numero_bultos")
     */
    private $numBultos;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="contenedoresMercancias")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Mercancia", inversedBy="contenedoresFormatos")
     * @ORM\JoinColumn(name="mercancia", referencedColumnName="id", nullable=true)
     */
    private $mercancia;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Contenedor", inversedBy="mercanciasFormatos")
     * @ORM\JoinColumn(name="contenedor", referencedColumnName="id", nullable=true)
     */
    private $contenedor;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Bulto", inversedBy="contenedorMercanciaFormatos")
     * @ORM\JoinColumn(name="bulto", referencedColumnName="id", nullable=false)
     */
    private $bulto;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set numBultos
     *
     * @param string $numBultos
     * @return ContenedorMercanciaFormato
     */
    public function setNumBultos($numBultos)
    {
        $this->numBultos = $numBultos;
    
        return $this;
    }

    /**
     * Get numBultos
     *
     * @return string 
     */
    public function getNumBultos()
    {
        return $this->numBultos;
    }

    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return ContenedorMercanciaFormato
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
     * Set mercancia
     *
     * @param \PuertoUDES\CommonBundle\Entity\Mercancia $mercancia
     * @return ContenedorMercanciaFormato
     */
    public function setMercancia(\PuertoUDES\CommonBundle\Entity\Mercancia $mercancia)
    {
        $this->mercancia = $mercancia;
    
        return $this;
    }

    /**
     * Get mercancia
     *
     * @return \PuertoUDES\CommonBundle\Entity\Mercancia 
     */
    public function getMercancia()
    {
        return $this->mercancia;
    }

    /**
     * Set contenedor
     *
     * @param \PuertoUDES\CommonBundle\Entity\Contenedor $contenedor
     * @return ContenedorMercanciaFormato
     */
    public function setContenedor(\PuertoUDES\CommonBundle\Entity\Contenedor $contenedor)
    {
        $this->contenedor = $contenedor;
    
        return $this;
    }

    /**
     * Get contenedor
     *
     * @return \PuertoUDES\CommonBundle\Entity\Contenedor 
     */
    public function getContenedor()
    {
        return $this->contenedor;
    }

    /**
     * Set bulto
     *
     * @param \PuertoUDES\CommonBundle\Entity\Bulto $bulto
     * @return ContenedorMercanciaFormato
     */
    public function setBulto(\PuertoUDES\CommonBundle\Entity\Bulto $bulto)
    {
        $this->bulto = $bulto;
    
        return $this;
    }

    /**
     * Get bulto
     *
     * @return \PuertoUDES\CommonBundle\Entity\Bulto 
     */
    public function getBulto()
    {
        return $this->bulto;
    }
}