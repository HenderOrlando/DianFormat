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
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->orderBy('a.num')
            ->from('PuertoUDESCommonBundle:Contenedor', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}