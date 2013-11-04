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
     * @ORM\ManyToMany(targetEntity="PuertoUDES\FosUsuarioBundle\Entity\FosUser", mappedBy="grupos")
     */
    protected $usuarios;
}