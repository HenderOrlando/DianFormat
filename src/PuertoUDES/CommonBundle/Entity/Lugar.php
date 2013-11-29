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
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="lugarCarga")
     */
    private $cargas;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Carga", mappedBy="lugarDescarga")
     */
    private $descargas;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato", mappedBy="lugar")
     */
    private $datosMercanciasFormato;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Entidad", mappedBy="lugar")
     */
    private $entidades;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="lugares")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=true)
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
        $this->descargas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add aduanas
     *
     * @param \PuertoUDES\CommonBundle\Entity\Aduana $aduana
     * @return Lugar
     */
    public function addAduana(\PuertoUDES\CommonBundle\Entity\Aduana $aduana)
    {
        $this->aduanas[] = $aduana;
    
        return $this;
    }

    /**
     * Remove aduanas
     *
     * @param \PuertoUDES\CommonBundle\Entity\Aduana $aduana
     */
    public function removeAduana(\PuertoUDES\CommonBundle\Entity\Aduana $aduana)
    {
        $this->aduanas->removeElement($aduana);
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
     * Add entidades
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Entidad $entidad
     * @return Lugar
     */
    public function addEntidad(\PuertoUDES\UsuariosBundle\Entity\Entidad $entidad)
    {
        $this->entidades[] = $entidad;
    
        return $this;
    }

    /**
     * Remove entidades
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Entidad $entidad
     */
    public function removeEntidad(\PuertoUDES\UsuariosBundle\Entity\Entidad $entidad)
    {
        $this->entidades->removeElement($entidad);
    }

    /**
     * Get entidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntidades()
    {
        return $this->entidades;
    }

    /**
     * Add cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $carga
     * @return Lugar
     */
    public function addCarga(\PuertoUDES\FormatosBundle\Entity\Carga $carga)
    {
        $this->cargas[] = $carga;
        return $this;
    }

    /**
     * Remove cargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $carga
     */
    public function removeCarga(\PuertoUDES\FormatosBundle\Entity\Carga $carga)
    {
        $this->cargas->removeElement($carga);
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
     * Add descargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $carga
     * @return Lugar
     */
    public function addDescarga(\PuertoUDES\FormatosBundle\Entity\Carga $carga)
    {
        $this->descargas[] = $carga;
        return $this;
    }

    /**
     * Remove datosMercanciasFormato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $datosMercanciasFormato
     */
    public function removeDatosMercanciasFormato(\PuertoUDES\FormatosBundle\Entity\Carga $datosMercanciasFormato)
    {
        $this->datosMercanciasFormato->removeElement($datosMercanciasFormato);
    }

    /**
     * Get datosMercanciasFormato
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatosMercanciasFormato()
    {
        return $this->datosMercanciasFormato;
    }
    /**
     * Add desdatosMercanciasFormato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercanciasFormato
     * @return Lugar
     */
    public function addDatosMercanciasFormato(\PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato $datosMercanciasFormato)
    {
        $this->datosMercanciasFormato[] = $datosMercanciasFormato;
        return $this;
    }

    /**
     * Remove descargas
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Carga $carga
     */
    public function removeDescarga(\PuertoUDES\FormatosBundle\Entity\Carga $carga)
    {
        $this->descargas->removeElement($carga);
    }

    /**
     * Get descargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDescargas()
    {
        return $this->descargas;
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
    
    public function __toString() {
        return $this->getLugar();
    }
    
    public function getLugar() {
        return $this->getNombre().', '.$this->getPais();
    }
    
    /**
     * Json aduanas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonAduanas($json = true)
    {
        $a = array();
        foreach ($this->getAduanas() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    /**
     * Json cargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonCargas($json = true)
    {
        $a = array();
        foreach ($this->getCargas() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    /**
     * Json entidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonEntidades($json = true)
    {
        $a = array();
        foreach ($this->getEntidades() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function json($json = true, $aduanas = false, $cargas = false, $entidades = false){
        $a = array_merge(parent::json(false), array(
            'pais'      =>  $this->getPais()->json(false),
        ));
        if(is_bool($aduanas) && $aduanas){
            $a = array_merge($a, array(
                'aduanas'   =>  $this->jsonAduanas(false),
            ));
        }
        if(is_bool($cargas) && $cargas){
            $a = array_merge($a, array(
                'cargas'    =>  $this->jsonCargas(false),
            ));
        }
        if(is_bool($entidades) && $entidades){
            $a = array_merge($a, array(
                'entidades' =>  $this->jsonEntidades(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE);
        if($this->getPais())
            $a .= '\\'.$this->getPais()->getTokens(false).' ';
        if(is_bool($explode) && $explode){
            $a = explode(' ', $a);
        }
        return $a;
    }
}