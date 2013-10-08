<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="_aplicable_a", fieldName="_aplicableA")
 * @ORM\DiscriminatorMap({
 *      "Usuario"="PuertoUDES\UsuariosBundle\Entity\Usuario",
 *      "Conductor"="PuertoUDES\UsuariosBundle\Entity\Conductor",
 *      "Entidad"="PuertoUDES\UsuariosBundle\Entity\Entidad"
 * })
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\UsuarioRepository")
 *
 */
class Usuario extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="direccion")
     */
    private $direccion;

    /** 
     * @ORM\Column(type="integer", length=11, nullable=true, name="telefono")
     */
    private $telefono;

    /** 
     * @ORM\Column(type="integer", length=11, nullable=false, name="doc_id")
     */
    private $docId;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="usuario")
     */
    private $formatos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="usuario")
     */
    private $gastos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set docId
     *
     * @param integer $docId
     * @return Usuario
     */
    public function setDocId($docId)
    {
        $this->docId = $docId;
    
        return $this;
    }

    /**
     * Get docId
     *
     * @return integer 
     */
    public function getDocId()
    {
        return $this->docId;
    }

    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     * @return Usuario
     */
    public function addFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     */
    public function removeFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos)
    {
        $this->formatos->removeElement($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->formatos;
    }

    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     * @return Usuario
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
}