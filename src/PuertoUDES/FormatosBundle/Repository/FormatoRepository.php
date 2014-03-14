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
    
    public function getAll($query = false, $querybuilder = false, $id_usuario = null)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESFormatosBundle:Formato', 'a');
        if(is_numeric($id_usuario)){
            $q
                ->join('a.usuarios', 'fu')
                ->andWhere('fu.usuario = '.$id_usuario);
        }
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    
    public function getMci($completo = null, $query = false, $querybuilder = false, $id_usuario = null){
        return $this->getByAbreviacion('mci', $completo, $query, $querybuilder, $id_usuario);
    }
    
    public function getCpic($completo = null, $query = false, $querybuilder = false, $id_usuario = null){
        return $this->getByAbreviacion('cpic', $completo, $query, $querybuilder, $id_usuario);
    }
    
    public function countFormatos($campo = 'id'){
        return $this->createQueryBuilder('f')
                ->select('COUNT(f.'.$campo.')')
                ->getQuery()
                ->getSingleScalarResult();
    }
    
    public function getByAbreviacion($abreviacion = null, $completo = null, $query = false, $querybuilder = false, $id_usuario = null){
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
        $q =  $this->getAll(false, true, $id_usuario);
        if(!is_null($completo) && is_bool($completo)){
            $q->andWhere('a.completo='.$completo);
        }
        if($abreviacion !== false){
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