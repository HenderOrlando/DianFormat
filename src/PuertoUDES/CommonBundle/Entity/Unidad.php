<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="unidad")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\UnidadRepository")
 */
class Unidad extends \PuertoUDES\CommonBundle\Entity\Objeto
{   
    /** 
     * @ORM\Column(type="string", length=5, nullable=false, name="abreviacion", unique=true)
     */
    private $abreviacion;
    
    /** 
     * @ORM\Column(type="string", length=5, nullable=false, name="canonical_abreviacion", unique=true)
     */
    private $canonicalAbreviacion;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato", mappedBy="unidadBultos")
     */
    private $contenedoresMercancias;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->contenedoresMercancias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE).' '
            .$this->getCanonicalAbreviacion()
            .$this->getAbreviacion();
        if(is_bool($explode) && $explode){
            $a = explode(' ', $a);
        }
        return $a;
    }
    
    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $formatos
     * @return Tipo
     */
    public function addContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercancia)
    {
        return $this->addContenedorMercancia($contenedorMercancia);
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $formatos
     */
    public function removeContenedorMercanciaFormato(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercancia)
    {
        $this->removeContenedorMercancia($contenedorMercancia);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedoresMercanciasFormato()
    {
        return $this->getContenedoresMercancias();
    }
    
    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $formatos
     * @return Tipo
     */
    public function addContenedorMercancia(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercancia)
    {
        $this->contenedoresMercancias[] = $contenedorMercancia;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $formatos
     */
    public function removeContenedorMercancia(\PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato $contenedorMercancia)
    {
        $this->contenedoresMercancias->removeElement($contenedorMercancia);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContenedoresMercancias()
    {
        return $this->contenedoresMercancias;
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
        $this->canonicalAbreviacion = $this->normaliza($abreviacion);
    
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
     * Get canonicalAbreviacion
     *
     * @return string 
     */
    public function getCanonicalAbreviacion()
    {
        return $this->canonicalAbreviacion;
    }

}