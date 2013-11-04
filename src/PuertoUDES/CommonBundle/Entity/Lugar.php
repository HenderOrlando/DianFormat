<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="lugar")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\LugarRepository")
 */
class Lugar extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\CommonBundle\Entity\Aduana", mappedBy="lugar")
     */
    private $aduanas;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="lugar")
     */
    private $cargas;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="lugares")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=false)
     */
    private $pais;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->aduanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cargas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add aduanas
     *
     * @param \PuertoUDES\CommonBundle\Entity\Aduana $aduanas
     * @return Lugar
     */
    public function addAduana(\PuertoUDES\CommonBundle\Entity\Aduana $aduanas)
    {
        $this->aduanas[] = $aduanas;
    
        return $this;
    }

    /**
     * Remove aduanas
     *
     * @param \PuertoUDES\CommonBundle\Entity\Aduana $aduanas
     */
    public function removeAduana(\PuertoUDES\CommonBundle\Entity\Aduana $aduanas)
    {
        $this->aduanas->removeElement($aduanas);
    }

    /**
     * Get aduanas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAduanas()
    {
        return $this->aduanas;
    }

    /**
     * Add cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $cargas
     * @return Lugar
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

    /**
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return Lugar
     */
    public function setPais(\PuertoUDES\CommonBundle\Entity\Pais $pais)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }
}