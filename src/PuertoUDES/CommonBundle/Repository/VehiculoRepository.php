<?php
namespace PuertoUDES\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class VehiculoRepository extends EntityRepository
{
    public function findAllOrderedByFechaCreado()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:Vehiculo u ORDER BY u.fechaCreado DESC'
            )
            ->getResult();
    }
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->orderBy('a.placa')
            ->from('PuertoUDESCommonBundle:Vehiculo', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}