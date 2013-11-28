<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\Criteria;

/** 
 * @ORM\Entity
 * @ORM\Table(name="condicion")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\CondicionRepository")
 */
class Condicion
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="condiciones")
     * @ORM\JoinColumn(name="formato_id", referencedColumnName="id", nullable=false)
     */
    private $formato;
    
    /**
     * @ORM\Column(type="text", nullable=false, name="condicion")
     */
    private $condicion;
    
    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="condiciones")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=false)
     */
    private $tipo;//transporte, pago
    
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
     * Get formato
     *
     * @return \PuertoUDES\FormatosBundle\Entity\Formato
     */
    public function getFormato()
    {
        return $this->formato;
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
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return Condicion
     */
    public function setFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formato)
    {
        $this->formato = $formato;
    
        return $this;
    }
    
    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
    }
    
    /**
     * Set condicion
     *
     * @param string $condicion
     * @return Condicion
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    
        return $this;
    }

    /**
     * Set tipo
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $tipo
     * @return Condicion
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
    
    public function json($json = true){
        $a = array(
            'tipo'      =>  $this->getTipo()->json(false),
            'condicion' =>  $this->getCondicion(),
            'formato'   =>  $this->getFormato()->json(false),
        );
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function __toString() {
        return $this->getCondicion();
    }
}