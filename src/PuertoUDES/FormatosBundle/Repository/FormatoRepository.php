<?php
namespace PuertoUDES\FormatosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class FormatoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESFormatosBundle:Formato u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESFormatosBundle:Formato', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    
    public function getMci($completo = null, $query = false, $querybuilder = false){
        return $this->getByAbreviacion('mci', $completo, $query, $querybuilder);
    }
    
    public function getCpic($completo = null, $query = false, $querybuilder = false){
        return $this->getByAbreviacion('cpic', $completo, $query, $querybuilder);
    }
    
    public function countFormatos($campo = 'id'){
        return $this->createQueryBuilder('f')
                ->select('COUNT(f.'.$campo.')')
                ->getQuery()
                ->getSingleScalarResult();
    }
    
    public function getByAbreviacion($abreviacion = null, $completo = null, $query = false, $querybuilder = false){
        $rta = null;
        if(is_string($abreviacion)){
            $r = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('r.id')
                    ->from('PuertoUDESCommonBundle:Tipo', 'r')
                    ->setMaxResults(1)
                    ->andWhere("r.abreviacion LIKE '%".$abreviacion."%'")
                    ->andWhere("r.aplicableA LIKE '%formato%'");
            $abreviacion = $r->getQuery()->getOneOrNullResult();
            if(isset($abreviacion['id']))
                $abreviacion = $abreviacion['id'];
            else
                $abreviacion = false;
        }elseif(is_object($abreviacion) && method_exists($abreviacion, 'getId')){
            $abreviacion = $abreviacion->getId();
        }elseif(!is_numeric($abreviacion)){
            $abreviacion = false;
        }
        $q =  $this->getAll(false, true);
        if($abreviacion !== false){
            if(!is_null($completo) && !is_bool($completo)){
                $q->andWhere('a.completo='.$completo);
            }
            $q->andWhere('a.tipo='.$abreviacion);
        }
//        $q->groupBy('a.usuario');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}