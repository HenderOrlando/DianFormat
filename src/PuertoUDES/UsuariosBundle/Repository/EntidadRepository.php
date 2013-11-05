<?php
namespace PuertoUDES\UsuariosBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EntidadRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM PuertoUDESUsuariosBundle:Entidad u ORDER BY u.nombre ASC'
            )
            ->getResult();
    }
    
    public function getAll($query = false, $querybuilder = false)
    {
        $q = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from('PuertoUDESUsuariosBundle:Usuario', 'a');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
    
    public function getRemitentes($formato = null, $query = false, $querybuilder = false){
        return $this->getByRol('remitente', $formato, $query, $querybuilder);
    }
    public function getDestinatarios($formato = null, $query = false, $querybuilder = false){
        return $this->getByRol('destinatario', $formato, $query, $querybuilder);
    }
    public function getTransportistas($formato = null, $query = false, $querybuilder = false){
        return $this->getByRol('transportista', $formato, $query, $querybuilder);
    }
    public function getConsignatarios($formato = null, $query = false, $querybuilder = false){
        return $this->getByRol('consignatario', $formato, $query, $querybuilder);
    }
    public function getNotificados($formato = null, $query = false, $querybuilder = false){
        return $this->getByRol('notificado', $formato, $query, $querybuilder);
    }
    
    public function getByRol($rol = null, $formato = null, $query = false, $querybuilder = false){
        $rta = null;
        if(is_string($rol)){
            $r = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('r.id')
                    ->from('PuertoUDESCommonBundle:Rol', 'r')
                    ->setMaxResults(1)
                    ->andWhere("r.canonical LIKE '%".$rol."%'")
                    ->andWhere("r.aplicableA LIKE '%formatousuario%'");
            $rol = $r->getQuery()->getOneOrNullResult();
            if(isset($rol['id']))
                $rol = $rol['id'];
            else
                $rol = false;
        }elseif(is_object($rol) && method_exists($rol, 'getId')){
            $rol = $rol->getId();
        }elseif(!is_numeric($rol)){
            $rol = false;
        }
        $q =  $this->getAll(false, true)
            ->innerJoin('a.formatos', 'f');
        if($rol !== false){
            if(!is_null($formato) && !empty($formato)){
                $id = false;
                if(is_numeric($formato))
                    $id = $formato;
                elseif(is_object($formato) && method_exists($formato, 'getId'))
                    $id = $formato->getId();
                if($id !== false)
                $q->andWhere('f.formato='.$id);
            }
            $q->andWhere('f.rol='.$rol);
        }
        $q->groupBy('f.usuario');
        if(is_bool($querybuilder) && $querybuilder)
            $rta = $q;
        elseif(is_bool($query) && $query)
            $rta = $q->getQuery();
        else
            $rta = $q->getQuery()->execute(null, \Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
        return $rta;
    }
}