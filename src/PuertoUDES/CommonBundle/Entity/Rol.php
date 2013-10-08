<?php
namespace PuertoUDES\CommonBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="rol")
 */
class Rol extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\OneToMany(targetEntity="PuertoUDES\FormatosBundle\Entity\FormatoUsuario", mappedBy="rol")
     */
    private $usuariosFormatos;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->usuariosFormatos = new \Doctrine\Common\Collections\ArrayCollection();
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
}