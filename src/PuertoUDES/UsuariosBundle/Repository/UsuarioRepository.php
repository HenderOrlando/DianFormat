<?php
namespace PuertoUDES\UsuariosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESUsuariosBundle:Usuario u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
}