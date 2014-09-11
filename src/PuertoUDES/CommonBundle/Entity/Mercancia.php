<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="mercancia")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\MercanciaRepository")
 */
class Mercancia extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", mappedBy="mercancia")
     */
    private $contenedoresFormatos;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="mercancia")
     */
    private $gastos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->contenedoresFormatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gasto
     * @return Gasto
     */
    public function addGasto(\PuertoUDES\FormatosBundle\Entity\Gasto $gasto)
    {
        $this->gastos[] = $gasto;
    
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
     * Add contenedoresFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresFormatos
     * @return Mercancia
     */
    public function addContenedoresFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresFormatos)
    {
        $this->contenedoresFormatos[] = $contenedoresFormatos;
    
        return $this;
    }

    /**
     * Remove contenedoresFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresFormatos
     */
    public function removeContenedoresFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedoresFormatos)
    {
        $this->contenedoresFormatos->removeElement($contenedoresFormatos);
    }

    /**
     * Get contenedoresFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedoresFormatos()
    {
        return $this->contenedoresFormatos;
    }
    
    public function __toString() {
        $parent = parent::__toString();
        if(empty($parent))
            return $this->getDescripcion ();
        return $parent;
    }
}