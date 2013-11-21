<?php
namespace PuertoUDES\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class DatosMercanciasFormatoRepository extends EntityRepository
{
    public function findAllOrderedByFechaCreado()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:DatosMercanciasFormato u ORDER BY u.fechaCreado DESC'
            )
            ->getResult();
    }
}