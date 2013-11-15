<?php
namespace PuertoUDES\UsuariosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ConductorRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESUsuariosBundle:Conductor u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESUsuariosBundle:Conductor', 'a')
//            ->innerJoin('a.usuario', 'u')
            ;
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}