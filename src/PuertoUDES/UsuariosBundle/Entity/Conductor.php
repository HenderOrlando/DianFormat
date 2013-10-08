<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="conductor")
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\ConductorRepository")
 */
class Conductor extends Usuario
{
    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="numero_licencia")
     */
    private $numLicencia;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="numero_licencia_tripulante")
     */
    private $numLibretaTripulante;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoConductor", mappedBy="conductor")
     */
    private $formatosConductor;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="conductores")
     * @ORM\JoinColumn(name="claseLicencia", referencedColumnName="id", nullable=false)
     */
    private $claseLicencia;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="conductores")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=false)
     */
    private $pais;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatosConductor = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set numLicencia
     *
     * @param string $numLicencia
     * @return Conductor
     */
    public function setNumLicencia($numLicencia)
    {
        $this->numLicencia = $numLicencia;
    
        return $this;
    }

    /**
     * Get numLicencia
     *
     * @return string 
     */
    public function getNumLicencia()
    {
        return $this->numLicencia;
    }

    /**
     * Set numLibretaTripulante
     *
     * @param string $numLibretaTripulante
     * @return Conductor
     */
    public function setNumLibretaTripulante($numLibretaTripulante)
    {
        $this->numLibretaTripulante = $numLibretaTripulante;
    
        return $this;
    }

    /**
     * Get numLibretaTripulante
     *
     * @return string 
     */
    public function getNumLibretaTripulante()
    {
        return $this->numLibretaTripulante;
    }

    /**
     * Add formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     * @return Conductor
     */
    public function addFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->formatosConductor[] = $formatosConductor;
    
        return $this;
    }

    /**
     * Remove formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     */
    public function removeFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->formatosConductor->removeElement($formatosConductor);
    }

    /**
     * Get formatosConductor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatosConductor()
    {
        return $this->formatosConductor;
    }

    /**
     * Set claseLicencia
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia
     * @return Conductor
     */
    public function setClaseLicencia(\PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia)
    {
        $this->claseLicencia = $claseLicencia;
    
        return $this;
    }

    /**
     * Get claseLicencia
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getClaseLicencia()
    {
        return $this->claseLicencia;
    }

    /**
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return Conductor
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