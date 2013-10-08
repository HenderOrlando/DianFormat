<?php
namespace PuertoUDES\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ContenedorMercanciaFormatoRepository extends EntityRepository
{
    public function findAllOrderedByFechaCreado()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:ContenedorMercanciaFormato u ORDER BY u.fechaCreado DESC'
            )
            ->getResult();
    }
}