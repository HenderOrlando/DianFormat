<?php
namespace PuertoUDES\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ContenedorRepository extends EntityRepository
{
    public function findAllOrderedByNumero()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:Contenedor u ORDER BY u.numero ASC'
            )
            ->getResult();
    }
}