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

    public function __construct()
    {
        parent::__construct();
    }
    
    public function setUsuario(\PuertoUDES\UsuariosBundle\Entity\Usuario $usuario){
        $this->usuario = $usuario;
        
        return $this;
    }
    
    public function getUsuario(){
        return $this->usuario;
    }
    
    public function usuarioId(){
        if($this->usuario)
            return $this->usuario->getId();
        return -1;
    }
    
}