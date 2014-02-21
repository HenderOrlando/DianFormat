<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="conductor")
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\ConductorRepository")
 */
class Conductor
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="conductor")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    
    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="numero_licencia")
     */
    private $numLicencia;

    /** 
     * @ORM\Column(type="string", length=11, nullable=false, name="numero_libreta_tripulante")
     */
    private $numLibretaTripulante;

    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoConductor", mappedBy="conductor")
     */
    private $formatosConductor;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Tipo", inversedBy="conductores")
     * @ORM\JoinColumn(name="claseLicencia", referencedColumnName="id", nullable=true)
     */
    private $claseLicencia;

    /** 
     * @ORM\ManyToOne(targetEntity="PuertoUDES\CommonBundle\Entity\Pais", inversedBy="conductores")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id", nullable=false)
     */
    private $pais;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formatosConductor = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numLicencia
     *
     * @param string $numLicencia
     * @return Conductor
     */
    public function setNumLicencia($numLicencia)
    {
        $this->numLicencia = $numLicencia;
    
        return $this;
    }

    /**
     * Get numLicencia
     *
     * @return string 
     */
    public function getNumLicencia()
    {
        return $this->numLicencia;
    }
    
    /**
     * Set usuario
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuario
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
     * Set numLibretaTripulante
     *
     * @param string $numLibretaTripulante
     * @return Conductor
     */
    public function setNumLibretaTripulante($numLibretaTripulante)
    {
        $this->numLibretaTripulante = $numLibretaTripulante;
    
        return $this;
    }

    /**
     * Get numLibretaTripulante
     *
     * @return string 
     */
    public function getNumLibretaTripulante()
    {
        return $this->numLibretaTripulante;
    }

    /**
     * Add formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     * @return Conductor
     */
    public function addFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->formatosConductor[] = $formatosConductor;
    
        return $this;
    }

    /**
     * Remove formatosConductor
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor
     */
    public function removeFormatosConductor(\PuertoUDES\FormatosBundle\Entity\FormatoConductor $formatosConductor)
    {
        $this->formatosConductor->removeElement($formatosConductor);
    }

    /**
     * Get formatosConductor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFormatosConductor()
    {
        return $this->formatosConductor;
    }

    /**
     * Set claseLicencia
     *
     * @param \PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia
     * @return Conductor
     */
    public function setClaseLicencia(\PuertoUDES\CommonBundle\Entity\Tipo $claseLicencia)
    {
        $this->claseLicencia = $claseLicencia;
    
        return $this;
    }

    /**
     * Get claseLicencia
     *
     * @return \PuertoUDES\CommonBundle\Entity\Tipo 
     */
    public function getClaseLicencia()
    {
        return $this->claseLicencia;
    }

    /**
     * Set pais
     *
     * @param \PuertoUDES\CommonBundle\Entity\Pais $pais
     * @return Conductor
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

    /**
     * Get nacionalidad
     *
     * @return \PuertoUDES\CommonBundle\Entity\Pais 
     */
    public function getNacionalidad()
    {
        return $this->pais->getNacionalidad();
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
        if($this->getUsuario()){
            return $this->getUsuario()->getDireccion();
        }
        return '';
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
        if($this->getUsuario()){
            return $this->getUsuario()->getTelefono();
        }
        return '';
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
        if($this->getUsuario()){
            return $this->getUsuario()->getDocId();
        }
        return '';
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
        if($this->getUsuario()){
            return $this->getUsuario()->getNombre();
        }
        return '';
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
        if($this->getUsuario()){
            return $this->getUsuario()->getTipoDocId();
        }
        return -1;
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
    
    public function json($json = true, $permisos = false){
        $a = array(
            'usuario'               => $this->getUsuario()->json(false),
            'pais'                  => $this->getPais()->json(false),
            'numLibretaTripulante'  => $this->getNumLibretaTripulante(),
            'numLicenciaConducir'   => $this->getNumLicencia(),
            'claseLicencia'         => $this->getClaseLicencia(),
        );
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function getTokens($explode = true){
        $a = $this->getUsuario()->getTokens(false)
            .'\\'.$this->getNumLibretaTripulante()
            .'\\'.$this->getClaseLicencia()
            .'\\'.$this->getNumLicencia();
        if(is_bool($explode) && $explode){
            $a = explode('\\', $a);
        }
        return $a;
    }
}