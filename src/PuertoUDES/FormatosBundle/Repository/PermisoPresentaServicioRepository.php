<?php
namespace PuertoUDES\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class PermisoPresentaServicioRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:PermisoPresentaServicio u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESFormatosBundle:PermisoPresentaServicio', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    
    public function like($params, $query = false){
        $q = $this->createQueryBuilder('pps');
        foreach($params as $name=>$val)
            $q->andWhere ('pps.'.$name." LIKE '%".$val."%'");
        $q = $q->getQuery();
        if($query)
            return $q;
        return $q->getOneOrNullResult();
    }
}