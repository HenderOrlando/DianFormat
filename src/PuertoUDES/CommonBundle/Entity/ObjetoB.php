<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\MappedSuperclass
 * @ORM\Table(name="objeto_b")
 */
class ObjetoB
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=100, nullable=false, name="marca")
     */
    private $marca;

    /** 
     * @ORM\Column(type="string", length=4, nullable=false, name="anio_fabrica")
     */
    private $anioFabrica;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="placa", unique=true)
     */
    private $placa;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="objetos")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=false)
     */
    private $pais;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime("now");
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
     * Set marca
     *
     * @param string $marca
     * @return ObjetoB
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
     * Set anioFabrica
     *
     * @param string $anioFabrica
     * @return ObjetoB
     */
    public function setAnioFabrica($anioFabrica)
    {
        $this->anioFabrica = $anioFabrica;
    
        return $this;
    }

    /**
     * Get anioFabrica
     *
     * @return string 
     */
    public function getAnioFabrica()
    {
        return $this->anioFabrica;
    }

    /**
     * Set placa
     *
     * @param string $placa
     * @return ObjetoB
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
    
        return $this;
    }

    /**
     * Get placa
     *
     * @return string 
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return ObjetoB
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
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return ObjetoB
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
        return $this->getPlaca().' '.$this->getMarca().' '.$this->getAnioFabrica();
    }
    
    public function json($json = true){
        $a = array(
            'id'            =>  $this->getId(),
            'placa'         =>  $this->getPlaca(),
            'marca'         =>  $this->getMarca(),
            'año_fabrica'   =>  $this->getAnioFabrica(),
            'fecha_creado'  =>  $this->getFechaCreado(),
            'pais'          =>  $this->getPais()->json(false),
        );
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    public function getTokens($explode = true){
        $a = $this->getPlaca().'\\'
            .$this->getMarca().'\\'
            .strtolower($this->getMarca()).'\\'
            .strtolower($this->getPlaca()).'\\'
            .  str_replace('-','\\',$this->getPlaca()).'\\'
            .$this->getAnioFabrica().'\\';
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }
}