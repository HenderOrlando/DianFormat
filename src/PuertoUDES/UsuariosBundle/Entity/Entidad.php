<?php
namespace PuertoUDES\UsuariosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="entidad")
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\EntidadRepository")
 */
class Entidad extends Usuario
{
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
        parent::__construct();
        $this->permisosPresentaServicios = new \Doctrine\Common\Collections\ArrayCollection();
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
}