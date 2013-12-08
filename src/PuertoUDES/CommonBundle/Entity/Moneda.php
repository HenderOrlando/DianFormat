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
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="moneda")
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
    
    /**
     * Json gastos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonGastos($json = true)
    {
        $a = array();
        foreach ($this->getGastos() as $g) {
            $a[$g->getId()] = $g->json(false);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function json($json = true, $gastos = false){
        $a = array_merge(parent::json(false), array(
            'abreviacion'     =>  $this->getAbreviacion(),
        ));
        if(is_bool($gastos) && $gastos){
            $a = array_merge($a, array(
                'gastos' => $this->jsonGastos(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }

    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE)
            .'\\'.$this->getAbreviacion();
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }
}