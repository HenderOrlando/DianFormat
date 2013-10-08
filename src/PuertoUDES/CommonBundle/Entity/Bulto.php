<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="bulto")
 */
class Bulto extends \PuertoUDES\CommonBundle\Entity\ObjetoC
{
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="marca")
     */
    private $marca;

    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="clase")
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
        parent::__construct();
        $this->contenedorMercanciaFormatos = new \Doctrine\Common\Collections\ArrayCollection();
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