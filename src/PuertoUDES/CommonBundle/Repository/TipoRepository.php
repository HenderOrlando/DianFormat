<?php
namespace PuertoUDES\CommonBundle\Repository;
use Doctrine\ORM\EntityRepository;

class TipoRepository extends EntityRepository
{
//    public function findAllOrderedByNombre()
//    {
//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT u FROM PuertoUDESCommonBundle:Tipo u ORDER BY u.nombre ASC'
//            )
//            ->getResult();
//    }
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESCommonBundle:Tipo', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    public function getClasesLicenciasConductor($query = false, $querybuilder = false)
    {
        return $this->getByAplicableA('conductor', $query, $querybuilder);
    }
    public function getNaturalezaCarga($query = false, $querybuilder = false)
    {
        return $this->getByAplicableA('carga', $query, $querybuilder);
    }
    public function getTiposFormato($query = false, $querybuilder = false)
    {
        return $this->getByAplicableA('formato', $query, $querybuilder);
    }
    public function getNivelesAduana($query = false, $querybuilder = false)
    {
        return $this->getByAplicableA('aduana', $query, $querybuilder);
    }
    public function getTipoUsuario($query = false, $querybuilder = false)
    {
        return $this->getByAplicableA('usuario', $query, $querybuilder);
    }
    public function getByAplicableA($aplicableA = null, $query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESCommonBundle:Tipo', 'a');
        if(!is_null($aplicableA))
            $q->andWhere("a.aplicableA LIKE '%".$aplicableA."%'");
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}