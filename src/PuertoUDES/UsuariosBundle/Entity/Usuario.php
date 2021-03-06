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
     * @ORM\Column(type="string", length=100, nullable=true, name="apellido")
     */
    private $apellido;
    
    /** 
     * @ORM\Column(type="text", nullable=true, name="direccion")
     */
    private $direccion;

    /** 
     * @ORM\Column(type="string", length=100, nullable=true, name="telefono")
     */
    private $telefono;

    /** 
     * @ORM\Column(type="string", length=15, nullable=false, name="doc_id")
     */
    private $docId;

    /**
     * @ORM\ManyToOne(targetEntity="\PuertoUDES\CommonBundle\Entity\Tipo")
     * @ORM\JoinColumn(name="tipo_doc_id", referencedColumnName="id")
     */
    private $tipoDocId;

    /** 
     * @ORM\OneToMany(targetEntity="\PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="usuario")
     */
    private $gastos;

    /**
     * @ORM\OneToOne(targetEntity="\PuertoUDES\UsuariosBundle\Entity\Entidad", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $entidad;

    /**
     * @ORM\OneToOne(targetEntity="\PuertoUDES\UsuariosBundle\Entity\Conductor", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $conductor;
    
    /** 
     * @ORM\ManyToMany(targetEntity="\PuertoUDES\CommonBundle\Entity\Rol", inversedBy="usuarios")
     * @ORM\JoinTable(
     *     name="rol_usuario", 
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $roles;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="usuario")
     */
    private $formatos;
    
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\Formato", mappedBy="autor")
     */
    private $formatos_autor;
    
    /**
     * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Grupo", mappedBy="docente")
     */
    protected $gruposDocente;
    
    /**
     * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Grupo", inversedBy="usuarios")
     * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id", nullable=true)
     */
    protected $grupo;
    
    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\FosUsuarioBundle\Entity\FosUser", cascade="all", mappedBy="usuario" )
     */
    protected $fosUsuario;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gastos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entidad = null;
        $this->conductor = null;
        $this->usuario = null;
        $this->grupo = null;
        $this->grupoDocente = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fosUsuario
     *
     * @param \PuertoUDES\FosUsuarioBundle\Entity\FosUser $fosUsuario
     * @return Usuario
     */
    public function setFosUsuario(\PuertoUDES\FosUsuarioBundle\Entity\FosUser $fosUsuario)
    {
        $this->fosUsuario = $fosUsuario;
    
        return $this;
    }

    /**
     * Get fosUsuario
     *
     * @return \PuertoUDES\FosUsuarioBundle\Entity\FosUser 
     */
    public function getFosUsuario()
    {
        return $this->fosUsuario;
    }
    
    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        if (is_numeric($telefono)) {
            $this->telefono = $telefono;
        }
    
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
     * @param string $docId
     * @return Usuario
     */
    public function setDocId($docId)
    {
        if (is_numeric($docId)) {
            $this->docId = $docId;
        }

        return $this;
    }

    /**
     * Get docId
     *
     * @return string 
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
     * @return \PuertoUDES\CommonBundle\Entity\Tipo
     */
    public function getTipoDocId()
    {
        return $this->tipoDocId;
    }

    /**
     * Add formatosEntidad
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     * @return Usuario
     */
    public function addFormatoEntidad(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->entidad->addFormato($formatos);
    
        return $this;
    }

    /**
     * Remove formatosEntidad
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatos
     */
    public function removeFormatoEntidad(\PuertoUDES\FormatosBundle\Entity\Formato $formatos)
    {
        $this->entidad->removeFormato($formatos);
    }

    /**
     * Get formatosEntidad
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatosEntidad()
    {
        return $this->entidad->getFormatos();
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
     * get TipoUsuario
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formato
     * 
     * @return \PuertoUDES\CommonBundle\Entity\Tipo
     */
    public function getTipoUsuario(\PuertoUDES\FormatosBundle\Entity\Formato $formato = null){
        if(!is_null($formato)){
            foreach($this->formatos as $f){
                if($f->getFormato()->getId() === $formato->getId()){
                    return $f->getTipo();
                }
            }
        }
        return null;
    }

    /**
     * Add formatosAutor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $formatos
     * @return Usuario
     */
    public function addFormatoAutor(\PuertoUDES\FormatosBundle\Entity\Formato $formato)
    {
        $this->formatos_autor[] = $formato;
    
        return $this;
    }

    /**
     * Remove formatosAutor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Formato $formatosAutor
     */
    public function removeFormatoAutor(\PuertoUDES\FormatosBundle\Entity\Formato $formatosAutor)
    {
        $this->formatos_autor->removeElement($formatosAutor);
    }

    /**
     * Get formatosAutor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatosAutor()
    {
        return $this->formatos_autor;
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
     * Has rol
     *
     * @return boolean
     */
    public function hasRol($rol_name)
    {
        return $this->roles->exists(function ($key, \PuertoUDES\CommonBundle\Entity\Rol $rol) use ($rol_name) {
            return $rol->getNombre() === $rol_name || $rol->getCanonical() === parent::normaliza($rol_name);
        });
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
     * Set conductor
     *
     * @param integer $conductor
     * @return Usuario
     */
    public function setConductor(\PuertoUDES\UsuariosBundle\Entity\Conductor $conductor)
    {
        $this->conductor = $conductor;
    
        return $this;
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
    
    /**
     * Set entidad
     *
     * @param integer $entidad
     * @return Usuario
     */
    public function setEntidad(\PuertoUDES\UsuariosBundle\Entity\Entidad $entidad)
    {
        $this->entidad = $entidad;
    
        return $this;
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

    /**
     * Set grupo
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Grupo $grupo
     * @return Conductor
     */
    public function setGrupo(\PuertoUDES\UsuariosBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;
    
        return $this;
    }

    /**
     * Get grupo
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
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
     * Set lugar
     *
     * @return Entidad
     */
    public function setLugar($lugar)
    {
        $this->entidad->setLugar($lugar);
    
        return $this;
    }
    
    /**
     * Get lugar
     *
     * @return \PuertoUDES\CommonBundle\Entity\Lugar
     */
    public function getLugar()
    {
        return $this->entidad->getLugar();
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
    
    public function json($json = true){
        $a = array_merge(parent::json(false), array(
            'direccion'     =>  $this->getDireccion(),
            'telefono'      =>  $this->getTelefono(),
            'tipo_doc_id'   =>  $this->getTipoDocId(),
            'doc_id'        =>  $this->getDocId(),
            'apellido'        =>  $this->getApellido(),
        ));
        if($this->getLugar()){
            $a['lugar'] = $this->getLugar()->json(false);
            $a['pais'] = $this->getLugar()->getPais()->getNombre();
            $a['ciudad'] = $this->getLugar()->getCiudad();
        }
        if($this->getEntidad()){
            $a['cod'] = $this->getEntidad()->getCod();
//            $a['entidad'] = $this->getEntidad()->json(false);
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }

    public function getTokens($explode = true){
        $a = parent::getTokens(FALSE)
            .'\\'.$this->getDocId()
            .'\\'.$this->getApellido();
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }
    
    public function canDelete(){
        return is_null($this->getEntidad()) && is_null($this->getConductor()) && $this->getFormatos()->isEmpty() && is_null($this->getGrupo()) && $this->gruposDocente->isEmpty();
    }
    
    public function whyCanDelete(){
        $msgs = array();
        if(!is_null($this->getEntidad())){
           $msgs['entidad'] = 'Es una Entidad';
        }
        if(!is_null($this->getConductor())){
           $msgs['conductor'] = 'Es un Conductor';
        }
        if(!$this->getFormatos()->isEmpty()){
           $msgs['formatos'] = 'Tiene '.$this->getFormatos()->count().' Formato'.($this->getFormatos()->count() !== 1?'s':'').' Asociados';
        }
        if(!is_null($this->getGrupo())){
           $msgs['grupos'] = 'Se encuantra en el grupo '.$this->getGrupo()->getNombre().' a cargo del docente '.$this->getGrupo()->getDocente();
        }
        if(!$this->gruposDocente->isEmpty()){
           $msgs['gruposDocente'] = 'Tiene a cargo '.$this->gruposDocente->count().' grupo'.($this->gruposDocente->count() !== 1?'s':'');
        }
        return $msgs;
    }
}