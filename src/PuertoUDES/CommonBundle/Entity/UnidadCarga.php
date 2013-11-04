<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="unidad_carga")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\UnidadCargaRepository")
 */
class UnidadCarga extends \PuertoUDES\CommonBundle\Entity\ObjetoB
{
    /** 
     * @ORM\ManyToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", inversedBy="unidadCargas")
     * @ORM\JoinTable(
     *     name="carga_unidad_carga", 
     *     joinColumns={@ORM\JoinColumn(name="id_unidad_carga", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_carga", referencedColumnName="id", nullable=false)}
     * )
     */
    private $cargas;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     * @return UnidadCarga
     */
    public function addCarga(\PuertoUDES\FormatosBundle\Entity\Carga $cargas)
    {
        $this->cargas[] = $cargas;
    
        return $this;
    }

    /**
     * Remove cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     */
    public function removeCarga(\PuertoUDES\FormatosBundle\Entity\Carga $cargas)
    {
        $this->cargas->removeElement($cargas);
    }

    /**
     * Get cargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCargas()
    {
        return $this->cargas;
    }
}