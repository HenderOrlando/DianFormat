<?php
namespace PuertoUDES\UsuariosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESUsuariosBundle:Usuario u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESFosUsuarioBundle:FosUser', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    public function getEstudiantes($query = false, $querybuilder = false)
    {
        return $this->getByRol('estudiante', $query, $querybuilder);
    }
    public function getDocentes($query = false, $querybuilder = false)
    {
        return $this->getByRol('docente', $query, $querybuilder);
    }
    public function getByRol($aplicableA = null, $query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESUsuariosBundle:Usuario', 'a')
            ->innerJoin('a.roles', 'r');
        if(!is_null($aplicableA)){
            $q->andWhere("r.aplicableA LIKE '%usuario%'");
            $q->andWhere("r.canonical LIKE '%".$aplicableA."%'");
        }
        $q->groupBy('a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}