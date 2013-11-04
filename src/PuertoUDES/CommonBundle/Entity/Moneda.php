<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="moneda")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\MonedaRepository")
 */
class Moneda extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\Column(type="string", length=5, nullable=false, name="abreviacion")
     */
    private $abreviacion;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="formato")
     */
    private $gastos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set abreviacion
     *
     * @param string $abreviacion
     * @return Moneda
     */
    public function setAbreviacion($abreviacion)
    {
        $this->abreviacion = $abreviacion;
    
        return $this;
    }

    /**
     * Get abreviacion
     *
     * @return string 
     */
    public function getAbreviacion()
    {
        return $this->abreviacion;
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
}