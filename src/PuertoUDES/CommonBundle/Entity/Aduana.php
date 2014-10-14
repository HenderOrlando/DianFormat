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
     * @ORM\Column(type="string", length=15, nullable=true, name="codigo")
     */
    private $cod;
    
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
    
    /**
     * Set cod
     *
     * @param string $cod
     * @return Entidad
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
    
        return $this;
    }

    /**
     * Get cod
     *
     * @return string 
     */
    public function getCod()
    {
        return $this->cod;
    }
    
    public function __toString() {
        return $this->getNombre();
    }


    /**
     * Json formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonFormatos($json = true)
    {
        $a = array();
        foreach ($this->getFormatos() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
//    public function json($json = true){
//        $a = array_merge(parent::json(false), array(
//            'lugar'    =>  $this->getLugar()->json(false),
//            'cod'      =>  $this->getCod(),
//        ));
//        if(is_bool($json) && $json){
//            return json_encode($a);
//        }
//        return $a;
//    }
//    public function getTokens($explode = true) {
//        $a = parent::getTokens(false).'\\'.$this->getCod();
//    }
}