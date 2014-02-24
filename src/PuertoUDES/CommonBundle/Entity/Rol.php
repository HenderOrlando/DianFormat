<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="PuertoUDES\CommonBundle\Repository\RolRepository")
 */
class Rol extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(targetEntity="\PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="rol")
     */
    private $usuariosFormatos;
    
    /** 
     * @ORM\ManyToMany(targetEntity="\PuertoUDES\UsuariosBundle\Entity\Usuario", mappedBy="roles")
     */
    private $usuarios;
    
    /** 
     * @ORM\Column(type="string", nullable=false, name="_aplicable_a")
     */
    private $aplicableA;
        
    /** 
     * @ORM\OneToMany(targetEntity="\PuertoUDES\FormatosBundle\Entity\Gasto", mappedBy="rolUsuario")
     */
    private $gastos;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuariosFormatos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set aplicableA
     *
     * @param string $aplicableA
     * @return Tipo
     */
    public function setAplicableA($aplicableA)
    {
        $this->aplicableA = $aplicableA;
    
        return $this;
    }

    /**
     * Get aplicableA
     *
     * @return string 
     */
    public function getAplicableA()
    {
        return $this->aplicableA;
    }
    
    /**
     * Add usuariosFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuariosFormatos
     * @return Rol
     */
    public function addUsuariosFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuariosFormatos)
    {
        $this->usuariosFormatos[] = $usuariosFormatos;
    
        return $this;
    }

    /**
     * Remove usuariosFormatos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuariosFormatos
     */
    public function removeUsuariosFormato(\PuertoUDES\FormatosBundle\Entity\FormatoUsuario $usuariosFormatos)
    {
        $this->usuariosFormatos->removeElement($usuariosFormatos);
    }

    /**
     * Get usuariosFormatos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuariosFormatos()
    {
        return $this->usuariosFormatos;
    }
    /**
     * Add usuario
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuario
     * @return Rol
     */
    public function addUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuarios[] = $usuario;
    
        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    
    /**
     * Add gastos
     *
     * @param \PuertoUDES\FormatosBundle\Entity\Gasto $gastos
     * @return Tipo
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
    
    public function is($rol){
        return $this->getCanonical() === parent::normaliza($rol);
    }
}