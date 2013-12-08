<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="contenedor_mercancia_formato")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\ContenedorMercanciaFormatoRepository")
 */
class ContenedorMercanciaFormato extends \PuertoUDES\CommonBundle\Entity\ObjetoC
{
    /** 
     * @ORM\Column(nullable=true, name="numero_bultos")
     */
    private $numBultos;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", inversedBy="contenedoresMercancias")
     * @ORM\JoinColumn(name="formato", referencedColumnName="id", nullable=false)
     */
    private $formato;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Mercancia", inversedBy="contenedoresFormatos")
     * @ORM\JoinColumn(name="mercancia", referencedColumnName="id", nullable=true)
     */
    private $mercancia;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Contenedor", inversedBy="mercanciasFormatos")
     * @ORM\JoinColumn(name="contenedor", referencedColumnName="id", nullable=true)
     */
    private $contenedor;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Bulto", inversedBy="contenedorMercanciaFormatos")
     * @ORM\JoinColumn(name="bulto", referencedColumnName="id", nullable=false)
     */
    private $bulto;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set numBultos
     *
     * @param string $numBultos
     * @return ContenedorMercanciaFormato
     */
    public function setNumBultos($numBultos)
    {
        $this->numBultos = $numBultos;
    
        return $this;
    }

    /**
     * Get numBultos
     *
     * @return string 
     */
    public function getNumBultos()
    {
        return $this->numBultos;
    }

    /**
     * Set formato
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * @return ContenedorMercanciaFormato
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
     * Set mercancia
     *
     * @param \PuertoUDES\CommonBundle\Entity\Mercancia $mercancia
     * @return ContenedorMercanciaFormato
     */
    public function setMercancia(\PuertoUDES\CommonBundle\Entity\Mercancia $mercancia)
    {
        $this->mercancia = $mercancia;
    
        return $this;
    }

    /**
     * Get mercancia
     *
     * @return \PuertoUDES\CommonBundle\Entity\Mercancia 
     */
    public function getMercancia()
    {
        return $this->mercancia;
    }

    /**
     * Set contenedor
     *
     * @param \PuertoUDES\CommonBundle\Entity\Contenedor $contenedor
     * @return ContenedorMercanciaFormato
     */
    public function setContenedor(\PuertoUDES\CommonBundle\Entity\Contenedor $contenedor)
    {
        $this->contenedor = $contenedor;
    
        return $this;
    }

    /**
     * Get contenedor
     *
     * @return \PuertoUDES\CommonBundle\Entity\Contenedor 
     */
    public function getContenedor()
    {
        return $this->contenedor;
    }

    /**
     * Set bulto
     *
     * @param \PuertoUDES\CommonBundle\Entity\Bulto $bulto
     * @return ContenedorMercanciaFormato
     */
    public function setBulto(\PuertoUDES\CommonBundle\Entity\Bulto $bulto)
    {
        $this->bulto = $bulto;
    
        return $this;
    }

    /**
     * Get bulto
     *
     * @return \PuertoUDES\CommonBundle\Entity\Bulto 
     */
    public function getBulto()
    {
        return $this->bulto;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->getBulto()->getMarca();
    }

    /**
     * Set marca bulto
     *
     * @param string $marca
     * @return ContenedorMercanciaFormato
     */
    public function setMarca($marca)
    {
        $this->getBulto()->setMarca($marca);
    
        return $this;
    }
    /**
     * Set clase
     *
     * @param string $clase
     * @return ContenedorMercanciaFormato
     */
    public function setClase($clase)
    {
        $this->getBulto()->setClase($clase);
    
        return $this;
    }
    
    public function json($json = true,
            $contenedor = false,
            $mercancia = false,
            $bulto = false,
            $formato = false
            ){
        $a = array_merge(parent::json(false),
            array(
                'numBultos'      =>  $this->getNumBultos(),
            )
        );
        if(is_bool($contenedor) && $contenedor){
            $a = array_merge($a, array(
                'contenedor' => $this->getContenedor()->json(false)
            ));
        }
        if(is_bool($formato) && $formato){
            $a = array_merge($a, array(
                'formato' => $this->getFormato()->json(false)
            ));
        }
        if(is_bool($bulto) && $bulto){
            $a = array_merge($a, array(
                'bulto' => $this->getBulto()->json(false)
            ));
        }
        if(is_bool($mercancia) && $mercancia){
            $a = array_merge($a, array(
                'mercancia' => $this->getMercancia()->json(false)
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}