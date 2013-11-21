<?php
namespace PuertoUDES\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class CondicionRepository extends EntityRepository
{
    public function findAllOrderedByFechaCreado()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:Condicion u ORDER BY u.fechaCreado DESC'
            )
            ->getResult();
    }
}