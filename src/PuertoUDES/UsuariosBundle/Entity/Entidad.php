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
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="entidad", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    
    /** 
     * @ORM\Column(type="string", length=50, nullable=true, name="certificado_idoneidad")
     */
    private $certificadoIdoneidad;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="transportista")
     */
    private $formatos;

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
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=true)
     */
    private $lugar;
    
    
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
    public function setUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
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
     * Set lugar
     *
     * @param string $lugar
     * @return Conductor
     */
    public function setLugar(\PuertoUDES\CommonBundle\Entity\Lugar $lugar)
    {
        $this->lugar = $lugar;
    
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
     * Has permisosPresentaServicios
     *
     * @param \PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios
     * @return boolean
     */
    public function hasPermisosPresentaServicio(\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $permisosPresentaServicios)
    {
        return $this->getPermisosPresentaServicios()->exists(function($key,\PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio $element) use ($permisosPresentaServicios) {
            if($permisosPresentaServicios->getId() === $element->getId())
                return true;
            return false;
        });
    }
    
    /**
     * get String permisosPresentaServicios
     *
     * @return string
     */
    public function getStringPermisosPresentaServicio()
    {
        $str = '';
        foreach ($this->getPermisosPresentaServicios() as $key => $element) {
            if(!empty($str))
                $str .= ', ';
            $str .= $element->getNombre();
        }
        return $str;
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
        return 'Certificado "'.$this->getCertificadoIdoneidad().'" '.($this->getUsuario()?'de "'.$this->getUsuario()->getNombre().'"':'');
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
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->getUsuario()->setApellido($apellido);
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->getUsuario()->getApellido();
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
     * Set canonical
     *
     * @param integer $canonical
     * @return Usuario
     */
    public function setCanonical($canonical)
    {
        $this->getUsuario()->setCanonical($canonical);
    
        return $this;
    }

    /**
     * Get canonical
     *
     * @return integer 
     */
    public function getCanonical()
    {
        return $this->getUsuario()->getCanonical();
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->getUsuario()->setNombre($nombre);
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer 
     */
    public function getNombre()
    {
        return $this->getUsuario()->getNombre();
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
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     * @return Usuario
     */
    public function addFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->formatos[] = $formatos;
    
        return $this;
    }

    /**
     * Remove formatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     */
    public function removeFormato(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
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
 
    /**
     * Json permisosPresentaServicios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonPermisosPresentaServicios($json = true)
    {
        $a = array();
        foreach ($this->getPermisosPresentaServicios() as $pps) {
            $a[$pps->getId()] = $pps->json($json);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function json($json = true, $permisos = false){
        $a = array(
            'lugar'                 => $this->getLugar()?$this->getLugar()->json(FALSE):null,
            'usuario'               => $this->getUsuario()->json(false),
            'certificado_idoneidad' => $this->getCertificadoIdoneidad(),
        );
        if(is_bool($permisos) && $permisos){
            $a = array_merge($a, array(
                'permisos' => $this->jsonPermisosPresentaServicios(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}