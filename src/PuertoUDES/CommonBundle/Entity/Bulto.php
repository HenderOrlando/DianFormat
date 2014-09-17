<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="bulto")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\BultoRepository")
 */
class Bulto
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="nombre", unique=true)
     */
    private $nombre;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="canonical", unique=true)
     */
    private $canonical;

    /** 
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $fechaCreado;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="marca")
     */
    private $marca;

    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="clase")
     */
    private $clase;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", mappedBy="bulto")
     */
    private $contenedorMercanciaFormatos;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime();
        $this->nombre = '';
        $this->contenedorMercanciaFormatos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return ObjetoC
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
     * Set canonical
     *
     * @param string $canonical
     * @return Objeto
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    
        return $this;
    }

    /**
     * Get canonical
     *
     * @return string 
     */
    public function getCanonical()
    {
        return $this->canonical;
    }
        
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Objeto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->setCanonical($this->normaliza($nombre));
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function __toString() {
        return $this->getNombre() != ''?$this->getMarca().' '.$this->getClase():$this->getNombre();
    }
    
    /**
     * Set marca
     *
     * @param string $marca
     * @return Bulto
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    
        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set clase
     *
     * @param string $clase
     * @return Bulto
     */
    public function setClase($clase)
    {
        $this->clase = $clase;
    
        return $this;
    }

    /**
     * Get clase
     *
     * @return string 
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Add contenedorMercanciaFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos
     * @return Bulto
     */
    public function addContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos)
    {
        $this->contenedorMercanciaFormatos[] = $contenedorMercanciaFormatos;
    
        return $this;
    }

    /**
     * Remove contenedorMercanciaFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos
     */
    public function removeContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercanciaFormatos)
    {
        $this->contenedorMercanciaFormatos->removeElement($contenedorMercanciaFormatos);
    }

    /**
     * Get contenedorMercanciaFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedorMercanciaFormatos()
    {
        return $this->contenedorMercanciaFormatos;
    }
    
    /**/
    protected function normaliza ($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return str_replace(' ', '-', utf8_encode($cadena));
    }
    
    public function json($json = true, $contenedores = false){
        $a = array(
            'id'        =>  $this->getId(),
            'marca'     =>  $this->getMarca(),
            'clase'     =>  $this->getClase(),
            'nombre'    =>  $this->getNombre(),
        );
        if(is_bool($contenedores) && $contenedores){
            $a = array_merge($a, array(
                'contenedores'  =>  $this->jsonContenedores()
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }

    public function getTokens($explode = true){
        $a = $this->getClase()
            .'\\'.$this->getMarca()
            .'\\'.$this->getNombre();
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }

    /**
     * Json contenedores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonContenedores($json = true)
    {
        $a = array();
        foreach ($this->getContenedorMercanciaFormatos() as $cmf) {
            $a[$cmf->getId()] = $cmf->json(false);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}