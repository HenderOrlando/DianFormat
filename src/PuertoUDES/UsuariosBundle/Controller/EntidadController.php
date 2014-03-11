<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Form\FormBuilder;
use PuertoUDES\UsuariosBundle\Entity\Entidad;
use PuertoUDES\UsuariosBundle\Entity\Usuario;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\UsuariosBundle\Repository\EntidadRepository;
use PuertoUDES\UsuariosBundle\Form\EntidadType;

/**
 * Entidad controller.
 *
 * @Route("/Entidad")
 */
class EntidadController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_entidades_")
     * @Route("/{rol}/Lista/para/{name}/", name="list_typeahead_entidades")
     * @Template("PuertoUDESFormatosBundle:Formato:_addEntidadCpicAjax.html.twig")
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = array();
        $name = $request->get('name','');
        if($name === 'lugar'){
            return JsonResponse::create($this->listTypeaheadLugares());
        }
        $rol = $request->get('rol','');
        switch(strtolower($rol)){
//            case 'notificado':
//                $entities = $this->getRepositorio()->getNotificados();
//                break;
//            case 'consignatario':
//                $entities = $this->getRepositorio()->getConsignatarios();
//                break;
//            case 'destinatario':
//                $entities = $this->getRepositorio()->getDestinatarios();
//                break;
//            case 'remitente':
//                $entities = $this->getRepositorio()->getRemitentes();
//                break;
//            case 'transportista':
//                $entities = $this->getRepositorio()->getTransportistas();
//                break;
//            default:
//                $entities = $this->getRepositorio()->findAll();
            default:
                $entities = $this->getRepositorio()->findAll();
                break;
        }
        $propertyPath = new PropertyAccessor();
        foreach($entities as $entidad){
            $value = $propertyPath->getValue($entidad,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $entidad->getTokens(),
                'datos' =>  $entidad->json(false)
            );
        }
        return JsonResponse::create($list);
    }
    
    public function listTypeaheadLugares($list = array()){
        $entities = $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Lugar')->findAll();
        foreach($entities as $lugar){
            $list[] = array(
                'value' =>  $lugar->__toString(),
                'tokens'=>  $lugar->getTokens(),
                'datos' =>  $lugar->json(false)
            );
        }
        return $list;
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/{rol}/a/CPIC-{fila}/{numero}/", name="entidad_add_cpic_ajax_")
     * @Route("/Agregar/{rol}/a/CPIC/{numero}/", name="entidad_add_cpic_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Formato:_addEntidadCpicAjax.html.twig")
     */
    public function addEntidadCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $role = $request->get('rol',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('nombre',NULL);
        $docId = $request->get('docId',NULL);
        $direccion = $request->get('direccion','');
        $lugar = $request->get('lugar',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic'));
        $entidad = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($docId && $nombre){
                    $entidad = $this->getRepositorio()->createQueryBuilder('e')
                        ->leftJoin('e.usuario', 'u')
                        ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                        ->andWhere("u.docId= '".$docId."'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$entidad){
                        $u = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->createQueryBuilder('u')
                            ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                            ->andWhere("u.docId= '".$docId."'")
                            ->getQuery()->getOneOrNullResult();
                        if(!$u){
                            $u = new Usuario();
                            $u->setNombre($nombre)
                              ->setDocId($docId)
                              ->setDireccion($direccion);
                            $em->persist($u);
                            $em->flush();
                        }
                        $entidad = new Entidad();
                        $entidad->setUsuario($u->setEntidad($entidad));
                        $lugar_pais = preg_split('/\s?,\s?/', $lugar);
                        if(count($lugar_pais) <= 2 && count($lugar_pais) > 1){
                            $pais = $em->getRepository('PuertoUDESCommonBundle:Pais')
                                    ->createQueryBuilder('p')
                                    ->andWhere('p.canonical LIKE \'%'.$lugar_pais[1].'%\' OR p.nombre LIKE \'%'.$lugar_pais[1].'%\'')
                                    ->getQuery()->getOneOrNullResult();
                                $l= $em->getRepository('PuertoUDESCommonBundle:Lugar')
                                    ->createQueryBuilder('p')
                                    ->andWhere('p.canonical = \''.$lugar_pais[0].'\' OR p.nombre = \''.$lugar_pais[0].'\'')
                                    ->getQuery()->getOneOrNullResult();
                                if(!$l){
                                    $l = new \PuertoUDES\CommonBundle\Entity\Lugar();
                                    $l->setNombre($lugar_pais[0]);
                                    $em->persist($l);
                                }
                                if(!$pais && isset($lugar_pais[1])){
                                    $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                                    $pais->setNombre($lugar_pais[1])
                                        ->setNacionalidad($lugar_pais[1]);
                                    $em->persist($pais);
                                }
                                if(!$pais->hasLugar($l)){
                                    $pais->addLugar($l);
                                    $em->persist($pais);
                                }
                                if(!$l->getPais() || $l->getPais()->getId() != $pais->getId()){
                                    $l->setPais($pais);
                                    $em->persist($l);
                                }
                                $entidad->setLugar($l);
                                $l->addEntidad($entidad);
                                $em->persist($l);
                        }
                        $u->setEntidad($entidad);
                        $em->persist($u);
                        $em->persist($entidad);
                    }else{
                        $u = $entidad->getUsuario();
                    }
                    
                    $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                            ->andWhere("r.canonical='".$role."' OR r.nombre='".$role."'")
                            ->getQuery()->getOneOrNullResult();
                    if(!$rol /*&& !empty($role)*/ || empty($role) ){
                        $datos['errors']['Formato'] = 'Rol no reconocido';
                        
//                        $rol = new \PuertoUDES\CommonBundle\Entity\Rol();
//                        $rol->setDescripcion('Rol '.$role.' de la Entidad, en Formato Usuario')
//                            ->setAplicableA('FormatoUsuario')
//                            ->setNombre($role);
//                        $em->persist($rol);
                    }else{
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->createQueryBuilder('fu')
                                ->andWhere("fu.usuario=".$u->getId())
                                ->andWhere("fu.rol=".$rol->getid())
                                ->getQuery()->getOneOrNullResult();
                        if(!$fu){
                            $fu = new \PuertoUDES\FormatosBundle\Entity\FormatoUsuario();
                            $fu->setFormato($formato);
                            $fu->setUsuario($u);
                            $fu->setRol($rol);
                            $em->persist($fu);
                        }else{
                            
                        }
//                        $u->addRol($rol);
                        $em->flush();
                        $datos['success']['msgs']['Formato'] = array(
                            'msg' => 'Entidad '.($role == 'notificar'?'a notificar':str_replace('tario', 'taria', $role)).' <strong>"'.$entidad->getNombre().'"</strong> agregada.',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $fu->getId();
                        $datos['datos'] = $fu->json(false);
                    }
                    return JsonResponse::create($datos);
                }else{
                    $datos['errors']['Formato'] = 'Llene los campos antes de guardar';
                    if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT')
                        return JsonResponse::create($datos);
                }
            }else{
                $datos['errors']['Formato'] = 'Formato no válido';
                return JsonResponse::create($datos);
            }
        }else{
            $datos['errors']['Tipo de Formato'] = 'Llene los campos antes de guardar';
            if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT')
                return JsonResponse::create($datos);
        }
        return array(
            'fila'          => $filas,
            'abreviacion'   =>  $formato->getTipo()->getAbreviacion(),
            'numero'        =>  $formato->getNumero(),
            'entidad'       =>  $entidad,
            'rol'           =>  $role,
        );
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Reset/{rol}/a/{abreviacion}-{fila}/{numero}/", name="entidad_add_cpic_ajax_reset_")
     * @Route("/Reset/{rol}/a/{abreviacion}/{numero}/", name="entidad_add_cpic_ajax_reset")
     * @Route("/Reset/{tipo}/a/{abreviacion}-{fila}/{numero}/", name="entidad_add_cpic_ajax_reset_tipo_")
     * @Route("/Reset/{tipo}/a/{abreviacion}/{numero}/", name="entidad_add_cpic_ajax_reset_tipo")
     * @Method({"DELETE"})
     * @Template()
     */
    public function resetAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $role = $request->get('rol',NULL);
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $abreviacion = strtolower($request->get('abreviacion',NULL));
        $pk = $request->get('pk',NULL);
        $entity = ucfirst($request->get('entity',NULL));
        $bundle = ucfirst($request->get('bundle',NULL));
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $abreviacion));
        $datos = array(
            'entity'        =>  $entity,
            'bundle'        =>  $bundle,
            'pk'            =>  $pk,
            'fila'          =>  $filas,
            'numero'        =>  $numero,
            'rol'           =>  $role,
            'abreviacion'   =>  $abreviacion,
        );
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                $obj = $em->getRepository('PuertoUDES'.$bundle.'Bundle:'.$entity)->find($pk);
                if($obj){
                    $remove = 'remove'.$entity;
                    $repository = 'Formato'.$entity;
                    if(strtolower($entity) == 'usuario'){
                        $find = array('formato' => $formato, strtolower($entity) => $obj);
                        if(is_string($role)){
                            $role = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                                    ->andWhere("r.canonical='".$role."' OR r.nombre='".$role."'")
                                    ->getQuery()->getOneOrNullResult();
                            if($role)
                                $find = array_merge($find,array('rol' => $role));
                        }
                        if(is_string($tipo)){
                            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->createQueryBuilder('t')
                                    ->andWhere("t.canonical LIKE '%".$tipo."%' OR t.nombre LIKE '%".$tipo."%' OR t.abreviacion LIKE '%".$tipo."%'")
                                    ->getQuery()->getOneOrNullResult();
                            if($tipo)
                                $find = array_merge($find,array('tipo' => $tipo));
                        }
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:'.$repository)->findOneBy($find);
                        $em->remove($fu);
                        $em->flush();
//                        $formato->$remove($fu);
//                        $obj->removeFormato($fu);
                    }
                    $datos['msgs']['Formato'] = array(
                        'msg' => 'Eliminado'.($role?' '.$role.' ':' ').$obj->__toString(),
                        'tipo' => 'success'
                    );
                }else{
                    $datos['msgs']['Formato'] = array(
                        'msg' => 'Ya está limpio',
                        'tipo' => 'danger'
                    );
                }
            }else{
                $datos['msgs']['Formato'] = array(
                    'msg' => 'Formato no válido',
                    'tipo' => 'danger'
                );
            }
        }else{
            $datos['msgs']['Formato'] = array(
                'msg' => 'Tipo de Formato no válido',
                'tipo' => 'danger'
            );
        }
        if(!$request->isXmlHttpRequest())
            throw $this->createNotFoundException('Lo siento, la Página no existe');
        return JsonResponse::create($datos);
    }
    
    /**
     * Lists all Entidad entities.
     *
     * @Route("/", name="entidad_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Entidades';
        $entity = 'Entidad';
        $bundle = 'Usuarios';
        $route = 'entidad_';
        $route_new = $route.'_new';
        $limit = 10;
        $utils = $this->getUtils();
        if(is_null($config)){
            $qb = $this->getRepositorio()->getAll(false, true);
        }else{
            $title = $config['title'];
            $entity = $config['entity'];
            $bundle = $config['bundle'];
            $route = $config['route'];
            $limit = $config['limit'];
            $qb = $config['qb'];
            $route_new = $config['route'].'_new';
        }
        
        $head = $this->getHeadFiltro($utils->getFormFilter(array(), $route, true), $route);
        $form = $head['filtros'];
        $head['filtros'] = $form->createView();
        $form->handleRequest($request);
        $data = array();
        if ($form->isValid()) {
           $data = $form->getData();
            $str_query = $utils->getQueryFilter($data, $head['fil'][0]['col'], $qb);
            if(!empty($str_query))
                $qb->andWhere($str_query);
        }
//        $qb = $qb->getQuery();
        $paginacion = $utils->getPaginacion($entity, $bundle, $limit, $route, $qb);
//        $paginacion['form_filter'] = $form;
        $botones = array(
//            array(
//                'url'   => $this->generateUrl($route_new),
//                'type'  => 'primary',
//                'class' => 'carga-modal',
//                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
//            ),
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render('FormatEasyCommonBundle:Plantilla:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Remitentes/", name="entidad__remitentes")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexRemitentesAction(Request $request)
    {   
        return $this->indexAction($request, array(
            'title'     =>  'Remitentes',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__remitentes',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getRemitentes(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Destinatarios/", name="entidad__destinatarios")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexDestinatariosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Destinatarios',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__destinatarios',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getDestinatarios(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Notificados/", name="entidad__notificados")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexNotificadosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Notificados',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__notificados',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getNotificados(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Consignatarios/", name="entidad__consignatarios")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexConsignatariosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Consignatarios',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__consignatarios',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getConsignatarios(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Transportistas/", name="entidad__transportistas")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexTransportistasAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Transportistas',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__transportistas',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getTransportistas(null, false, true),
        ));
    }
    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Transportista/Guardar/{tipo}/{numero}/", name="entidad_save_transportista_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveTransportistaAjaxAction(Request $request){
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('nombre',NULL);
        $doc_id = $request->get('docId',NULL);
        $direccion = $request->get('direccion','');
        $telefono = $request->get('telefono','');
        $lugar = $request->get('lugar',NULL);
        $certificado = $request->get('certificadoIdoneidad',NULL);
        $em = $this->getDoctrine()->getManager();
        $datos = array(
            'errors' => array(),
        );
        
        if($tipo){
            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($tipo)));
            if(is_numeric($numero)){
                $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero, 'tipo' => $tipo));
                if($formato){
                    if($doc_id && $nombre){
                        $entidad = $this->getRepositorio()->createQueryBuilder('e')
                            ->leftJoin('e.usuario', 'u')
                            ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                            ->andWhere("u.docId= '".$doc_id."'")
                            ->getQuery()->getOneOrNullResult();
                        if(!$entidad){
                            $u = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->createQueryBuilder('u')
                                ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                                ->andWhere("u.docId= '".$doc_id."'")
                                ->getQuery()->getOneOrNullResult();
                            if(!$u){
                                $u = new Usuario();
                                $u->setNombre($nombre);
                                $u->setDocId($doc_id);
                                $u->setDireccion($direccion);
                                $u->setTelefono($telefono);
                                $em->persist($u);
                            }
                            $entidad = new Entidad();
                            $entidad->setCertificadoIdoneidad($certificado)
                                    ->setUsuario($u->setEntidad($entidad));
                            $lugar_pais = preg_split('/\s?,\s?/', $lugar);
                            if(count($lugar_pais) <= 2 && count($lugar_pais) > 1){
                                $pais = $em->getRepository('PuertoUDESCommonBundle:Pais')
                                    ->createQueryBuilder('p')
                                    ->andWhere('p.canonical LIKE \'%'.$lugar_pais[1].'%\' OR p.nombre LIKE \'%'.$lugar_pais[1].'%\'')
                                    ->getQuery()->getOneOrNullResult();
                                $l= $em->getRepository('PuertoUDESCommonBundle:Lugar')
                                    ->createQueryBuilder('p')
                                    ->andWhere('p.canonical = \''.$lugar_pais[0].'\' OR p.nombre = \''.$lugar_pais[0].'\'')
                                    ->getQuery()->getOneOrNullResult();
                                if(!$l){
                                    $l = new \PuertoUDES\CommonBundle\Entity\Lugar();
                                    $l->setNombre($lugar_pais[0]);
                                    $em->persist($l);
                                }
                                if(!$pais && isset($lugar_pais[1])){
                                    $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                                    $pais->setNombre($lugar_pais[1])
                                        ->setNacionalidad($lugar_pais[1]);
                                    $em->persist($pais);
                                }
                                if(!$pais->hasLugar($l)){
                                    $pais->addLugar($l);
                                    $em->persist($pais);
                                }
                                if(!$l->getPais() || $l->getPais()->getId() != $pais->getId()){
                                    $l->setPais($pais);
                                    $em->persist($l);
                                }
                                $entidad->setLugar($l);
                                $l->addEntidad($entidad);
                                $em->persist($l);
                            }
                            $em->persist($entidad);
                            $u->setEntidad($entidad);
                            $em->persist($u);
                            $em->flush();
                        }else{
                            $u = $entidad->getUsuario();
                        }
                        $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->findOneBy(array('canonical' => 'transportista', 'aplicableA' => 'Usuario'));
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->findOneBy(array('usuario' => $u->getId(), 'formato' => $formato->getId(), 'rol' => $rol->getId()));
                        if(!$fu){
                            $fu = new \PuertoUDES\FormatosBundle\Entity\FormatoUsuario();
                            $fu->setRol($rol)
                                ->setFormato($formato)
                                ->setUsuario($entidad->getUsuario());
                            $em->persist($fu);
//                            $u->addRol('ROLE_'.strtoupper($rol->getCanonical()));
                            $u->addRol($rol);
                        }
                        $formato->setTransportista($entidad);
                        $em->persist($formato);
                        $em->flush();
                        $datos['success']['msgs']['Entidad'] = array(
                            'msg' => 'Entidad <strong>"'.$entidad->getNombre().'"</strong> fué creada',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $entidad->getId();
                    }else{
                        $datos['errors']['Entidad'] = 'Datos incompletos. Son necesarios El NIT y la Razón Social';
                        $datos['errors'] = array(
                            'tipo' => $request->get('tipo',NULL),
                            'numero' => $request->get('numero',NULL),
                            'nombre' => $request->get('nombre',NULL),
                            'doc_id' => $request->get('doc_id',NULL),
                            'direccion' => $request->get('direccion',NULL),
                            'telefono' => $request->get('telefono',NULL),
                            'lugar' => $request->get('lugar',NULL),
                            'certificado' => $request->get('certificadoIdoneidad',NULL),
                        );
                    }
                }else{
                    $datos['errors']['Formato'] = 'Formato no encontrado';
                }
            }
            else{
                $datos['errors']['Número'] = 'Número de formato no válido';
            }
        }
        else{
            $datos['errors']['Tipo'] = 'Tipo de Formato no válido';
        }
        return JsonResponse::create($datos);
    }
    /**
     * Creates a new Entidad entity.
     *
     * @Route("/", name="entidad__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Entidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Entidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/new", name="entidad__new")
     * @Route("/new/Remitentes/", name="entidad__remitentes_new")
     * @Route("/new/Destinatarios/", name="entidad__destinatarios_new")
     * @Route("/new/Transportistas/", name="entidad__transportistas_new")
     * @Route("/new/Consignatarios/", name="entidad__Consignatario_new")
     * @Route("/new/Notificados/", name="entidad__notificados_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Entidad();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nueva Entidad',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Entidad entity.
     *
     * @Route("/{id}", name="entidad__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => $entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESUsuariosBundle:Entidad:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Entidad entity.
     *
     * @Route("/{id}/edit", name="entidad__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $parametros = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        $template = 'edit';
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => $entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entidad entity.
     *
     * @Route("/{id}", name="entidad__update")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Entidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Entidad entity.
     *
     * @Route("/{id}", name="entidad__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entidad_'));
    }

    /**
     * Creates a form to delete a Entidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entidad__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * get Utils
     * 
     * @return IndexController Utilidades de PuertoUDES
     */
    public function getUtils() {
        return $this->get('puertoudes.util');
    }
    
    /**
     * get Repositorio
     * 
     * @return EntidadRepository  EntidadRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESUsuariosBundle:Entidad');
    }
    
    public function getHeadFiltro(FormBuilder $form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'      =>  'DocId',
                        'label'     =>  'Documento de Identidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Direccion',
                        'label'     =>  'Dirección',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'telefono',
                        'label'     =>  'Teléfono',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Certificado Idoneidad',
                        'label'     =>  'Certificado Idoneidad',
                        'join'     =>  'entidad',
                        'class' =>  'text-center',
                    ),
//                    array(
//                        'dato'    =>   'tipoDocId',
//                        'label'     =>  'Tipo de Documento de dentidad',
//                        'join'     =>  'tipoDocId',
//                        'class' =>  'text-center',
//                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'entidad__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'entidad__delete',
                                'data_url'=> array('id'),
                                'type'  => 'danger',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                            ),
                        )
                    ),
                )
            ),
        );
        return $this->getUtils()->getHeadFiltro($filas, $form, $route);
    }
}
