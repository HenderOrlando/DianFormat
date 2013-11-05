<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * 
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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo")
     * @ORM\JoinColumn(name="tipo_doc_id", referencedColumnName="id")
     */
    private $tipoDocId;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="usuario")
     */
    private $formatos;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="usuario")
     */
    private $gastos;

    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Entidad", mappedBy="usuario")
     */
    private $entidad;

    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Conductor", mappedBy="usuario")
     */
    private $conductor;
    
    /** 
     * @ORM\ManyToMany(targetEntity="PuertoUDES\CommonBundle\Entity\Rol", inversedBy="usuarios")
     * @ORM\JoinTable(
     *     name="rol_usuario", 
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $roles;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entidad = new \PuertoUDES\UsuariosBundle\Entity\Entidad();
        $this->conductor = new \PuertoUDES\UsuariosBundle\Entity\Conductor();
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
     * Set docId
     *
     * @param integer $tipoDocId
     * @return Usuario
     */
    public function setTipoDocId($tipoDocId)
    {
        $this->tipoDocId = $tipoDocId;
    
        return $this;
    }

    /**
     * Get docId
     *
     * @return integer 
     */
    public function getTipoDocId()
    {
        return $this->tipoDocId;
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
     * Add roles
     *
     * @param \PuertoUDES\CommonBundle\Entity\Rol $roles
     * @return Usuario
     */
    public function addRol(\PuertoUDES\CommonBundle\Entity\Rol $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \PuertoUDES\CommonBundle\Entity\Rol $roles
     */
    public function removeRol(\PuertoUDES\CommonBundle\Entity\Rol $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
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

    /**
     * Get conductor
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Conductor
     */
    public function getConductor()
    {
        return $this->conductor;
    }

    /**
     * Get entidad
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Entidad
     */
    public function getEntidad()
    {
        return $this->entidad;
    }
    
    
    
    /*CONDUCTOR*/
    /**
     * Set numLicencia
     *
     * @param string $numLicencia
     * @return Conductor
     */
    public function setNumLicencia($numLicencia)
    {
        $this->conductor->setNumLicencia($numLicencia);
    
        return $this;
    }

    /**
     * Get numLicencia
     *
     * @return string 
     */
    public function getNumLicencia()
    {
        return $this->conductor->getNumLicencia();
    }

    /**
     * Set numLibretaTripulante
     *
     * @param string $numLibretaTripulante
     * @return Conductor
     */
    public function setNumLibretaTripulante($numLibretaTripulante)
    {
        $this->conductor->setNumLibretaTripulante($numLibretaTripulante);
    
        return $this;
    }

    /**
     * Get numLibretaTripulante
     *
     * @return string 
     */
    public function getNumLibretaTripulante()
    {
        return $this->conductor->getNumLibretaTripulante();
    }

    /**
     * Add formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     * @return Conductor
     */
    public function addFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->conductor->addFormatosConductor($formatosConductor);
    
        return $this;
    }

    /**
     * Remove formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     */
    public function removeFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->conductor->removeFormatosConductor($formatosConductor);
    }

    /**
     * Get formatosConductor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatosConductor()
    {
        return $this->conductor->getFormatosConductor();
    }

    /**
     * Set claseLicencia
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia
     * @return Conductor
     */
    public function setClaseLicencia(\PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia)
    {
        $this->conductor->setClaseLicencia($claseLicencia);
    
        return $this;
    }

    /**
     * Get claseLicencia
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getClaseLicencia()
    {
        return $this->conductor->getClaseLicencia();
    }

    /**
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return Conductor
     */
    public function setPais(\PuertoUDES\CommonBundle\Entity\Pais $pais)
    {
        $this->conductor->setPais($pais);
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->conductor->getPais();
    }
    /*ENTIDAD*/
    /**
     * Set certificadoIdoneidad
     *
     * @param string $certificadoIdoneidad
     * @return Entidad
     */
    public function setCertificadoIdoneidad($certificadoIdoneidad)
    {
        $this->entidad->setCertificadoIdoneidad($certificadoIdoneidad);
    
        return $this;
    }

    /**
     * Get certificadoIdoneidad
     *
     * @return string 
     */
    public function getCertificadoIdoneidad()
    {
        return $this->entidad->getCertificadoIdoneidad();
    }

    /**
     * Add permisosPresentaServicios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios
     * @return Entidad
     */
    public function addPermisosPresentaServicio(\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios)
    {
        $this->entidad->addPermisosPresentaServicio($permisosPresentaServicios);
    
        return $this;
    }

    /**
     * Remove permisosPresentaServicios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios
     */
    public function removePermisosPresentaServicio(\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios)
    {
        $this->entidad->removePermisosPresentaServicio($permisosPresentaServicios);
    }

    /**
     * Get permisosPresentaServicios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisosPresentaServicios()
    {
        return $this->entidad->getPermisosPresentaServicios();
    }
}