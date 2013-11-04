<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="aduana")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\AduanaRepository")
 */
class Aduana extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoAduana", mappedBy="aduana")
     */
    private $fomatos;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar", inversedBy="aduanas")
     * @ORM\JoinColumn(name="lugar", referencedColumnName="id", nullable=false)
     */
    private $lugar;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->fomatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add fomatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatos
     * @return Aduana
     */
    public function addFomato(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatos)
    {
        $this->fomatos[] = $fomatos;
    
        return $this;
    }

    /**
     * Remove fomatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatos
     */
    public function removeFomato(\PuertoUDES\FormatosBundle\Entity\FormatoAduana $fomatos)
    {
        $this->fomatos->removeElement($fomatos);
    }

    /**
     * Get fomatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFomatos()
    {
        return $this->fomatos;
    }

    /**
     * Set lugar
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugar
     * @return Aduana
     */
    public function setLugar(\PuertoUDES\CommonBundle\Entity\Lugar $lugar)
    {
        $this->lugar = $lugar;
    
        return $this;
    }

    /**
     * Get lugar
     *
     * @return \PuertoUDES\CommonBundle\Entity\Lugar 
     */
    public function getLugar()
    {
        return $this->lugar;
    }
}