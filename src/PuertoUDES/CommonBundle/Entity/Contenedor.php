<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="contenedor")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\ContenedorRepository")
 */
class Contenedor
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="num")
     */
    private $numero;

    /** 
     * @ORM\Column(type="decimal", nullable=false, precision=10, scale=2, name="capacidad")
     */
    private $capacidad;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="sigla_numero")
     */
    private $sigla;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\OneToMany(
     *     targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", 
     *     mappedBy="contenedor"
     * )
     */
    private $mercanciasFormatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime('now');
        $this->mercanciasFormatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Contenedor
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
     * Set numero
     *
     * @param string $numero
     * @return Contenedor
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set capacidad
     *
     * @param float $capacidad
     * @return Contenedor
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;
    
        return $this;
    }

    /**
     * Get capacidad
     *
     * @return float 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Contenedor
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Contenedor
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
     * Add mercanciasFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $mercanciasFormatos
     * @return Contenedor
     */
    public function addMercanciasFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $mercanciasFormatos)
    {
        $this->mercanciasFormatos[] = $mercanciasFormatos;
    
        return $this;
    }

    /**
     * Remove mercanciasFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $mercanciasFormatos
     */
    public function removeMercanciasFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $mercanciasFormatos)
    {
        $this->mercanciasFormatos->removeElement($mercanciasFormatos);
    }

    /**
     * Get mercanciasFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMercanciasFormatos()
    {
        return $this->mercanciasFormatos;
    }
    
    public function json($json = true){
        $a = array(
            'id'        =>  $this->getId(),
            'sigla'     =>  $this->getSigla(),
            'numero'    =>  $this->getNumero(),
            'capacidad' =>  $this->getCapacidad(),
        );
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}