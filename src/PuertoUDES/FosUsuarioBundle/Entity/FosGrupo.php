<?php

namespace PuertoUDES\FosUsuarioBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_grupo")
 */
class FosGrupo extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
     
     /**
      * @ORM\OneToMany(targetEntity="PuertoUDES\UsuariosBundle\Entity\Usuario", mappedBy="grupo")
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
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }
}