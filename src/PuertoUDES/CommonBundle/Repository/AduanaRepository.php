<?php
namespace PuertoUDES\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class AduanaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:Aduana u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESCommonBundle:Aduana', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}