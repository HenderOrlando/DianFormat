<?php
namespace PuertoUDES\FosUsuarioBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class FosUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario")
     */
    protected $usuario;
    
    /**
     * @ORM\ManyToMany(targetEntity="PuertoUDES\FosUsuarioBundle\Entity\FosGrupo", inversedBy="usuarios")
     * @ORM\JoinTable(name="fos_user_group",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="grupo_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    public function __construct()
    {
        parent::__construct();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario){
        $this->usuario = $usuario;
        
        return $this;
    }
    
    public function getUsuario(){
        return $this->usuario;
    }
}