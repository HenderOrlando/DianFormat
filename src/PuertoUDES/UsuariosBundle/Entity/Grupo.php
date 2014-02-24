<?php

namespace PuertoUDES\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="grupo")
 * @ORM\Entity(repositoryClass="PuertoUDES\UsuariosBundle\Repository\GrupoRepository")
 */
class Grupo extends \PuertoUDES\CommonBundle\Entity\Objeto
{
     
     /**
      * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", mappedBy="grupo", cascade={"persist"})
      */
    protected $usuarios;
     
     /**
      * @ORM\ManyToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", inversedBy="gruposDocente")
      * @ORM\JoinColumn(name="docente_id", referencedColumnName="id", nullable=true)
      */
    protected $docente;
    
    public function __construct()
    {
        parent::__construct();
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get entidad
     *
     * @return \PuertoUDES\UsuariosBundle\Entity\Usuario
     */
    public function getDocente()
    {
        return $this->docente;
    }
    
    /**
     * Set usuario
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuario
     * @return Usuario
     */
    public function setDocente(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->docente = $usuario;
    
        return $this;
    }
    
    /**
     * Add usuarios
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuarios
     * @return Usuario
     */
    public function addUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;
    
        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}