<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="bulto")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\BultoRepository")
 */
class Bulto
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="nombre")
     */
    private $nombre;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $fechaCreado;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="marca")
     */
    private $marca;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="clase")
     */
    private $clase;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", mappedBy="bulto")
     */
    private $contenedorMercanciaFormatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime();
        $this->nombre = '';
        $this->contenedorMercanciaFormatos = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Objeto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->setCanonical($this->normaliza($nombre));
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function __toString() {
        return $this->getNombre() != ''?$this->getMarca().' '.$this->getClase():$this->getNombre();
    }
    
    /**
     * Set marca
     *
     * @param string $marca
     * @return Bulto
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    
        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set clase
     *
     * @param string $clase
     * @return Bulto
     */
    public function setClase($clase)
    {
        $this->clase = $clase;
    
        return $this;
    }

    /**
     * Get clase
     *
     * @return string 
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Add contenedorMercanciaFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos
     * @return Bulto
     */
    public function addContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos)
    {
        $this->contenedorMercanciaFormatos[] = $contenedorMercanciaFormatos;
    
        return $this;
    }

    /**
     * Remove contenedorMercanciaFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos
     */
    public function removeContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos)
    {
        $this->contenedorMercanciaFormatos->removeElement($contenedorMercanciaFormatos);
    }

    /**
     * Get contenedorMercanciaFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedorMercanciaFormatos()
    {
        return $this->contenedorMercanciaFormatos;
    }
}