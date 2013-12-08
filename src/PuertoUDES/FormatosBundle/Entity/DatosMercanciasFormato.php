<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\Criteria;

/** 
 * @ORM\Entity
 * @ORM\Table(name="datos_mercancias_formato")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\DatosMercanciasFormatoRepository")
 */
class DatosMercanciasFormato
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="datosMercancias")
     * @ORM\JoinColumn(name="formato_id", referencedColumnName="id", nullable=false)
     */
    private $formato;
    
    /**
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar", inversedBy="datosMercanciasFormato")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=true)
     */
    private $lugar;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="datosMercancias")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=false)
     */
    private $tipo;//recibe, embarque, entrega

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="fecha")
     */
    private $fecha;
    
    /** 
     * @ORM\Column(type="datetime", nullable=false, name="fecha_creado")
     */
    private $fechaCreado;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreado = new \DateTime('now');
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
     * Get formato
     *
     * @return \PuertoUDES\FormatosBundle\Entity\Formato
     */
    public function getFormato()
    {
        return $this->formato;
    }
    
    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return DatosMercanciasFormato
     */
    public function setFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formato)
    {
        $this->formato = $formato;
    
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
     * Set lugar
     *
     * @param \PuertoUDES\CommonBundle\Entity\Lugar $lugar
     * @return DatosMercanciasFormato
     */
    public function setLugar(\PuertoUDES\CommonBundle\Entity\Lugar $lugar)
    {
        $this->lugar = $lugar;
    
        return $this;
    }

    /**
     * Set tipo
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $tipo
     * @return DatosMercanciasFormato
     */
    public function setTipo(\PuertoUDES\CommonBundle\Entity\Tipo $tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * Set fechaCreado
     *
     * @param \DateTime $fechaCreado
     * @return Objeto
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Objeto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function json($json = true){
        $a = array(
            'tipo'      =>  $this->getTipo()->json(false),
            'lugar'     =>  $this->getLugar()->json(false),
            'formato'   =>  $this->getFormato()->json(false),
        );
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function __toString() {
        return $this->getLugar().' '.$this->getFecha()->format('d-m-y');
    }
}