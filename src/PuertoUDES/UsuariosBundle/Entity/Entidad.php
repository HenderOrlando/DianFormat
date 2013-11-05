<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="entidad")
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\EntidadRepository")
 */
class Entidad
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="entidad")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=false, name="certificado_idoneidad")
     */
    private $certificadoIdoneidad;

    /** 
     * @ORM\ManyToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio", inversedBy="entidades")
     * @ORM\JoinTable(
     *     name="permiso_presenta_servicio_entidad", 
     *     joinColumns={@ORM\JoinColumn(name="entidad", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="permiso_presenta_servicio", referencedColumnName="id", nullable=false)}
     * )
     */
    private $permisosPresentaServicios;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permisosPresentaServicios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->certificadoIdoneidad = null;
    }
    
    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set usuario
     *
     * @param string $usuario
     * @return Conductor
     */
    public function setUsuario(PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * Set certificadoIdoneidad
     *
     * @param string $certificadoIdoneidad
     * @return Entidad
     */
    public function setCertificadoIdoneidad($certificadoIdoneidad)
    {
        $this->certificadoIdoneidad = $certificadoIdoneidad;
    
        return $this;
    }

    /**
     * Get certificadoIdoneidad
     *
     * @return string 
     */
    public function getCertificadoIdoneidad()
    {
        return $this->certificadoIdoneidad;
    }

    /**
     * Add permisosPresentaServicios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios
     * @return Entidad
     */
    public function addPermisosPresentaServicio(\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios)
    {
        $this->permisosPresentaServicios[] = $permisosPresentaServicios;
    
        return $this;
    }

    /**
     * Remove permisosPresentaServicios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios
     */
    public function removePermisosPresentaServicio(\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios)
    {
        $this->permisosPresentaServicios->removeElement($permisosPresentaServicios);
    }

    /**
     * Get permisosPresentaServicios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisosPresentaServicios()
    {
        return $this->permisosPresentaServicios;
    }
    /**
     * {inheritance}
     */
    public function __toString() {
        return 'Certificado "'.$this->getCertificadoIdoneidad().'" de "'.$this->getUsuario()->getNombre().'"';
    }
    
    /*USUARIO*/
    
    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
     */
    public function setDireccion($direccion)
    {
        $this->getUsuario()->setDireccion($direccion);
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->getUsuario()->getDireccion();
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->getUsuario()->setTelefono($telefono);
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->getUsuario()->getTelefono();
    }

    /**
     * Set docId
     *
     * @param integer $docId
     * @return Usuario
     */
    public function setDocId($docId)
    {
        $this->getUsuario()->setDocId($docId);
    
        return $this;
    }

    /**
     * Get docId
     *
     * @return integer 
     */
    public function getDocId()
    {
        return $this->getUsuario()->getDocId();
    }

    /**
     * Set docId
     *
     * @param integer $tipoDocId
     * @return Usuario
     */
    public function setTipoDocId($tipoDocId)
    {
        $this->getUsuario()->setTipoDocId($tipoDocId);
    
        return $this;
    }

    /**
     * Get docId
     *
     * @return integer 
     */
    public function getTipoDocId()
    {
        return $this->getUsuario()->getTipoDocId();
    }

    /**
     * Add formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     * @return Usuario
     */
    public function addFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos)
    {
        $this->getUsuario()->addFormato($formatos);
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     */
    public function removeFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos)
    {
        $this->getUsuario()->removeFormato($formatos);
    }

    /**
     * Get formatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatos()
    {
        return $this->getUsuario()->getFormatos();
    }

    /**
     * Add roles
     *
     * @param \PuertoUDES\CommonBundle\Entity\Rol $roles
     * @return Usuario
     */
    public function addRol(\PuertoUDES\CommonBundle\Entity\Rol $roles)
    {
        $this->getUsuario()->addRol($roles);
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \PuertoUDES\CommonBundle\Entity\Rol $roles
     */
    public function removeRol(\PuertoUDES\CommonBundle\Entity\Rol $roles)
    {
        $this->getUsuario()->removeRol($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->getUsuario()->getRoles();
    }

    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     * @return Usuario
     */
    public function addGasto(\PuertoUDES\FormatosBundle\Entity\Gasto $gastos)
    {
        $this->getUsuario()->addGasto($gastos);
    
        return $this;
    }

    /**
     * Remove gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     */
    public function removeGasto(\PuertoUDES\FormatosBundle\Entity\Gasto $gastos)
    {
        $this->getUsuario()->removeGasto($gastos);
    }

    /**
     * Get gastos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastos()
    {
        return $this->getUsuario()->getGastos();
    }
}