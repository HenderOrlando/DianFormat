<?php
namespace PuertoUDES\FormatosBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="permiso_presenta_servicio")
 * @ORM\Entity(repositoryClass="PuertoUDES\FormatosBundle\Repository\PermisoPresentaServicioRepository")
 */
class PermisoPresentaServicio extends \PuertoUDES\CommonBundle\Entity\Objeto
{
    /** 
     * @ORM\ManyToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Entidad", mappedBy="permisosPresentaServicios")
     */
    private $entidades;
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->entidades = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add entidades
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Entidad $entidades
     * @return PermisoPresentaServicio
     */
    public function addEntidad(\PuertoUDES\UsuariosBundle\Entity\Entidad $entidades)
    {
        $this->entidades[] = $entidades;
    
        return $this;
    }

    /**
     * Remove entidades
     *
     * @param \PuertoUDES\UsuariosBundle\Entity\Entidad $entidades
     */
    public function removeEntidad(\PuertoUDES\UsuariosBundle\Entity\Entidad $entidades)
    {
        $this->entidades->removeElement($entidades);
    }

    /**
     * Get entidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntidades()
    {
        return $this->entidades;
    }
    
    /**
     * Json entidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function jsonEntidades($json = true)
    {
        $a = array();
        foreach($this->getEntidades() as $e)
            $a[$e->getId()] = $e->json($json);
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
    
    public function json($json = true, $entidades = false){
        $a = parent::json(false);
        if(is_bool($entidades) && $entidades){
            $a = array_merge($a, array(
                'entidades'     =>  $this->jsonEntidades(false),
            ));
        }
        if(is_bool($json) && $json){
            return json_encode($a);
        }
        return $a;
    }
}