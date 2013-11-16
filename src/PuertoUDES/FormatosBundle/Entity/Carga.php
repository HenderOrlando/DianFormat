<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="carga")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\CargaRepository")
 */
class Carga
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="integer", length=11, nullable=true, name="num_precintos")
     */
    private $numPrecintos;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="cargas")
     * @ORM\JoinColumn(name="naturaleza", referencedColumnName="id", nullable=true)
     */
    private $naturalezaCarga;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="cargas")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar", inversedBy="cargas")
     * @ORM\JoinColumn(name="lugar_carga", referencedColumnName="id", nullable=true)
     */
    private $lugarCarga;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar", inversedBy="descargas")
     * @ORM\JoinColumn(name="lugar_descarga", referencedColumnName="id", nullable=true)
     */
    private $lugarDescarga;

    /** 
     * @ORM\ManyToMany(targetEntity="PuertoUDES\CommonBundle\Entity\UnidadCarga", mappedBy="cargas")
     */
    private $unidadCargas;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unidadCargas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fechaCreado = new \DateTime();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Carga
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numPrecintos
     *
     * @param integer $numPrecintos
     * @return Carga
     */
    public function setNumPrecintos($numPrecintos)
    {
        $this->numPrecintos = $numPrecintos;
    
        return $this;
    }

    /**
     * Get numPrecintos
     *
     * @return integer 
     */
    public function getNumPrecintos()
    {
        return $this->numPrecintos;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Carga
     */
    public function setFechaCreado($fechaCreado)
    {
        $this->fechaCreado = $fechaCreado;
    
        return $this;
    }

    /**
     * Get fechaCreado
     *
     * @return \DateTime 
     */
    public function getFechaCreado()
    {
        return $this->fechaCreado;
    }

    /**
     * Set naturalezaCarga
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $naturalezaCarga
     * @return Carga
     */
    public function setNaturalezaCarga(\PuertoUDES\CommonBundle\Entity\Tipo $naturalezaCarga)
    {
        $this->naturalezaCarga = $naturalezaCarga;
    
        return $this;
    }

    /**
     * Get naturalezaCarga
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getNaturalezaCarga()
    {
        return $this->naturalezaCarga;
    }

    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return Carga
     */
    public function setFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formato)
    {
        $this->formato = $formato;
    
        return $this;
    }

    /**
     * Get formato
     *
     * @return \PuertoUDES\FormatosBundle\Entity\Formato 
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set lugarCarga
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugar
     * @return Carga
     */
    public function setLugarCarga(\PuertoUDES\CommonBundle\Entity\Lugar $lugar)
    {
        $this->lugarCarga = $lugar;
    
        return $this;
    }

    /**
     * Get lugarCarga
     *
     * @return \PuertoUDES\CommonBundle\Entity\Lugar 
     */
    public function getLugarCarga()
    {
        return $this->lugarCarga;
    }

    /**
     * Set lugarDescarga
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugar
     * @return Carga
     */
    public function setLugarDescarga(\PuertoUDES\CommonBundle\Entity\Lugar $lugar)
    {
        $this->lugarDescarga = $lugar;
    
        return $this;
    }

    /**
     * Get lugarDescarga
     *
     * @return \PuertoUDES\CommonBundle\Entity\Lugar 
     */
    public function getLugarDescarga()
    {
        return $this->lugarDescarga;
    }

    /**
     * Add unidadCargas
     *
     * @param \PuertoUDES\CommonBundle\Entity\UnidadCarga $unidadCargas
     * @return Carga
     */
    public function addUnidadCarga(\PuertoUDES\CommonBundle\Entity\UnidadCarga $unidadCargas)
    {
        $this->unidadCargas[] = $unidadCargas;
    
        return $this;
    }

    /**
     * Remove unidadCargas
     *
     * @param \PuertoUDES\CommonBundle\Entity\UnidadCarga $unidadCargas
     */
    public function removeUnidadCarga(\PuertoUDES\CommonBundle\Entity\UnidadCarga $unidadCargas)
    {
        $this->unidadCargas->removeElement($unidadCargas);
    }

    /**
     * Get unidadCargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnidadCargas()
    {
        return $this->unidadCargas;
    }
    
    /**
     * Json unidadesCargas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonUnidadesCargas($json = true)
    {
        $a = array();
        foreach ($this->getUnidadCargas() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function json($json = true, $unidadesCarga = false){
        $a = array(
            'id'                =>  $this->getId(),
            'carga'             =>  $this->getLugarCarga()?$this->getLugarCarga()->json(false):'',
            'descarga'          =>  $this->getLugarDescarga()?$this->getLugarDescarga()->json(false):'',
            'naturaleza'        =>  $this->getNaturalezaCarga()?$this->getNaturalezaCarga()->json(false):'',
            'numero_precintos'  =>  $this->getNumPrecintos(),
        );
        if(is_bool($unidadesCarga) && $unidadesCarga){
            $a = array_merge($a, array(
                'unidades_carga'    => $this->jsonUnidadesCarga(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }

    /**
     * Has unidadCargas
     *
     * @param \PuertoUDES\CommonBundle\Entity\UnidadCarga $unidadCarga
     * @return boolean
     */
    public function hasUnidadCargas($unidadCarga) {
        return $this->getUnidadCargas()->exists(function($key,\PuertoUDES\CommonBundle\Entity\UnidadCarga $element) use ($unidadCarga) {
            if($unidadCarga->getId() === $element->getId())
                return true;
            return false;
        });
    }
}