<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="vehiculo")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\VehiculoRepository")
 */
class Vehiculo extends \PuertoUDES\CommonBundle\Entity\ObjetoB
{
    /** 
     * @ORM\Column(type="string", length=18, nullable=false, name="num_serie_chasis", unique=true)
     */
    private $numeroSerieChasis;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="certifica_habilita")
     */
    private $certificadoHabilitacion;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoConductor", mappedBy="vehiculo")
     */
    private $formatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set numeroSerieChasis
     *
     * @param integer $numeroSerieChasis
     * @return Vehiculo
     */
    public function setNumeroSerieChasis($numeroSerieChasis)
    {
        $this->numeroSerieChasis = $numeroSerieChasis;
        return $this;
    }

    /**
     * Get numeroSerieChasis
     *
     * @return integer 
     */
    public function getNumeroSerieChasis()
    {
        return $this->numeroSerieChasis;
    }

    /**
     * Set certificadoHabilitacion
     *
     * @param integer $certificadoHabilitacion
     * @return Vehiculo
     */
    public function setCertificadoHabilitacion($certificadoHabilitacion)
    {
        $this->certificadoHabilitacion = $certificadoHabilitacion;
    
        return $this;
    }

    /**
     * Get certificadoHabilitacion
     *
     * @return integer 
     */
    public function getCertificadoHabilitacion()
    {
        return $this->certificadoHabilitacion;
    }

    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatos
     * @return Vehiculo
     */
    public function addFormato(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatos
     */
    public function removeFormato(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatos)
    {
        $this->formatos->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->formatos;
    }
    
    public function numSerieChasis(){
        return $this->getNumeroSerieChasis();
    }
    public function certificaHabilita(){
        return $this->getCertificadoHabilitacion();
    }
    
    public function json($json = true, $permisos = false){
        $a = array_merge(parent::json(false),array(
            'numeroSerieChasis'      => $this->getNumeroSerieChasis(),
            'certificadoHabilitacion'=> $this->getCertificadoHabilitacion(),
        ));
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function getTokens($explode = true){
        $a = parent::getTokens(false)
            .'\\'.$this->getCertificadoHabilitacion()
            .'\\'.  str_replace('-','\\',$this->getCertificadoHabilitacion())
            .'\\'.$this->getNumeroSerieChasis();
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }
}