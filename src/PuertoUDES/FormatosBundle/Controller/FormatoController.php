<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\FormatosBundle\Entity\Formato;
use PuertoUDES\FormatosBundle\Form\FormatoType;

/**
 * Formato controller.
 *
 * @Route("/Formato")
 */
class FormatoController extends Controller
{

    /**
     * Lists all Formato entities.
     *
     * @Route("/", name="formato_")
     * @Route("/Formatos/{maxResult}/", name="formato_maxResult")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null, $maxResult = false)
    {
        $title = 'Formatos';
        $entity = 'Formato';
        $bundle = 'Formato';
        $route = 'formato_';
        $limit = 5;
        if(is_int($maxResult)){
            $limit = $maxResult;
        }
        $utils = $this->getUtils();
        if(is_null($config)){
            if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SUPER_ADMIN') || $this->getUser()->getUsuario()->hasRol('Docente')){
                $qb = $this->getRepositorio()->getAll(false, true);
            }else{
                $qb = $this->getRepositorio()->getAll(false, true, $this->getUser()->getUsuario()->getId());
            }
        }else{
            $title = $config['title'];
            $entity = $config['entity'];
            $bundle = $config['bundle'];
            $route = $config['route'];
            $limit = $config['limit'];
            $qb = $config['qb'];
        }
        
        $head = $this->getHeadFiltro($utils->getFormFilter(array(), $route, true), $route, is_null($config));
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
        if(!is_null($config) && isset($config['abrevia']))
            $url_ = $this->generateUrl('formato__new_', array('abrevia' => $config['abrevia']));
        else
            $url_ = $this->generateUrl('formato__new');
        $botones = array(
            array(
                'url'   => $url_,
                'type'  => 'primary',
                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
                'class' => 'carga-modal',
            ),
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
            'datos_form'       =>  $data,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false) || (isset($config['ajax']) && $config['ajax'])){
            return $this->render('PuertoUDESCommonBundle:Plantilla:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Lists all Formato entities.
     *
     * @Route("/CPIC/", name="formato__cpic")
     * @Route("/CPIC/{maxResult}/", name="formato__cpic_maxResult")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function cpicAction(Request $request, $maxResult = false)
    {
        if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SUPER_ADMIN') || $this->getUser()->getUsuario()->hasRol('Docente')){
            $qb = $this->getRepositorio()->getCpic(null, false, true);
        }else{
            $qb = $this->getRepositorio()->getCpic(null, false, true, $this->getUser()->getUsuario()->getId());
        }
        $limit = 5;
        if(is_int($maxResult)){
            $limit = $maxResult;
        }
        return $this->indexAction($request, array(
            'title'     =>  'Carta de Porte Internacional por Carretera',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'cpic',
            'route'     =>  'formato__cpic',
            'limit'     =>  $limit,
            'qb'        =>  $qb,
        ));
    }
    public function cpicAjaxAction(Request $request, $maxResult = false)
    {
        if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SUPER_ADMIN') || $this->getUser()->getUsuario()->hasRol('Docente')){
            $qb = $this->getRepositorio()->getCpic(null, false, true);
        }else{
            $qb = $this->getRepositorio()->getCpic(null, false, true, $this->getUser()->getUsuario()->getId());
        }
        $limit = 5;
        if(is_int($maxResult)){
            $limit = $maxResult;
        }
        return $this->indexAction($request, array(
            'title'     =>  '',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'cpic',
            'route'     =>  'formato__cpic',
            'limit'     =>  $limit,
            'qb'        =>  $qb,
            'ajax'      =>  true,
        ));
    }
    /**
     * Lists all Formato entities.
     *
     * @Route("/MCI/", name="formato__mci")
     * @Route("/MCI/maxResult/", name="formato__mci_maxResult")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function mciAction(Request $request, $maxResult = false)
    {
        if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SUPER_ADMIN') || $this->getUser()->getUsuario()->hasRol('Docente')){
            $qb = $this->getRepositorio()->getMci(null, false, true);
        }else{
            $qb = $this->getRepositorio()->getMci(null, false, true, $this->getUser()->getUsuario()->getId());
        }
        $limit = 5;
        if(is_int($maxResult)){
            $limit = $maxResult;
        }
        return $this->indexAction($request, array(
            'title'     =>  'Manifiesto de Carga Internacional',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'mci',
            'route'     =>  'formato__mci',
            'limit'     =>  5,
            'qb'        =>  $qb,
        ));
    }
    public function mciAjaxAction(Request $request, $maxResult = false)
    {
        if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_SUPER_ADMIN') || $this->getUser()->getUsuario()->hasRol('Docente')){
            $qb = $this->getRepositorio()->getMci(null, false, true);
        }else{
            $qb = $this->getRepositorio()->getMci(null, false, true, $this->getUser()->getUsuario()->getId());
        }
        $limit = 5;
        if(is_int($maxResult)){
            $limit = $maxResult;
        }
        return $this->indexAction($request, array(
            'title'     =>  '',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'mci',
            'route'     =>  'formato__mci',
            'limit'     =>  5,
            'qb'        =>  $qb,
            'ajax'      =>  true,
        ));
    }
    
    /**
     * Creates a new Formato entity.
     *
     * @Route("/{abrevia}", name="formato__create_")
     * @Route("/", name="formato__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Formato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Formato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->findOneBy(array('canonical' => 'autor'));
            if($rol){
                $fu = new \PuertoUDES\FormatosBundle\Entity\FormatoUsuario();
                $fu
                    ->setFormato($entity)
                    ->setUsuario($this->getUser()->getUsuario())
                    ->setRol($rol)
                ;
                $em->persist($fu);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('formato__edit', array('id' => $entity->getId())));
//            return $this->redirect($this->generateUrl('formato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__create'),
            'method' => 'POST',
            'attr'   => array(
                    'class'  =>  'inputBig form-horizontal',
                    'role'   =>  'form'
                )
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Agregar',
            'attr' => array('class' => 'btn btn-lg btn-success')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Editar-Campo/{tipo}/", name="formato_edit_campo")
     * @Method("PUT")
     * @Template()
     */
    public function editCampoAction(Request $request){
        $nombre = $request->get('name',NULL);
        $valor = $request->get('value',NULL);
        $llave = $request->get('pk',NULL);
        $save = $request->get('save',NULL);
        $entity = $request->get('entity',NULL);
        $bundle = $request->get('bundle',NULL);
        $em = $this->getDoctrine()->getManager();
        $valores = array();
        $obj = null;
        if(!$llave){
            try{
                $obj = $em->getRepository('PuertoUDES'.ucfirst($bundle).'Bundle:'.ucfirst($entity))->findBy(array($nombre => $valor));
                if($obj){
                    $valores['msgs'][] = array('msg' => 'El '.$entity.' ya existe.', 'tipo' => 'success');
    //                $valores['datos'] = $obj->json();
                }else{
                    $valores['msgs'][] = array('msg' => 'El '.$entity.' no existe.', 'tipo' => 'info');
                }
            }catch(\Doctrine\ORM\ORMException $e){
                
            }
        }else{
            $obj = $this->getDoctrine()->getManager()->getRepository('PuertoUDES'.ucfirst($bundle).'Bundle:'.ucfirst($entity))->find($llave);
            $addName = 'add'. ucfirst($entity);
            $set = 'set'. ucfirst($nombre);
            $get = 'get'. ucfirst($nombre);
            if($entity == 'gasto' && $nombre == 'valor')
                $valor = str_replace (',', '.', $valor);
            if($nombre == 'pesoBruto' || $nombre == 'pesoNeto'){
                $valor = str_replace (',', '.', $valor);
                if(($nombre == 'pesoBruto' && method_exists($obj, 'getPesoNeto') && $valor < $obj->getPesoNeto()) || ($nombre == 'pesoNeto' && method_exists($obj, 'getPesoBruto') && $valor > $obj->getPesoBruto())){
                    $valores['msgs'][] = array('msg' =>'Formato: El peso bruto debe ser mayor que el Peso Neto.', 'tipo' => 'danger');
                    return JsonResponse::create($valores);
                }
            }
            if($obj){
                if($entity === 'contenedorMercanciaFormato' && $nombre === 'descripcion' && is_a($obj, 'PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato')){
                    $mercancia = $em->getRepository('PuertoUDESCommonBundle:Mercancia')
                        ->createQueryBuilder('m')
                        ->andWhere('m.descripcion LIKE \'%'.$valor.'%\'')
                        ->getQuery()->getOneOrNullResult();
                    if(!$mercancia){
                        $mercancia = new \PuertoUDES\CommonBundle\Entity\Mercancia();
                        $mercancia->setDescripcion($valor);
                        $em->persist($mercancia);
                    }
                    $obj->setMercancia($mercancia);
                    $em->persist($obj);
                    $em->flush();
                    $valores['datos'] = $obj->json(false);
                }
                else if(strpos(strtolower ($nombre), 'lugar') !== false){
                    $lugar_pais = preg_split('/\s?,\s?/', ucwords($valor));
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
                        $obj->$set($l);
                        $em->persist($obj);
                        $l->$addName($obj);
                        $em->persist($l);
                        $em->flush();
                        $valores['datos'] = $obj->json(false);
                    }else{
                        
                    }
                }elseif(strpos($nombre, 'naturaleza') !== false){
                    $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')
                        ->createQueryBuilder('t')
                        ->andWhere('t.canonical LIKE \'%'.$valor.'%\' OR t.nombre LIKE \'%'.$valor.'%\'')
                        ->getQuery()->getOneOrNullResult();
                    if(!$tipo){
                        $tipo = new \PuertoUDES\CommonBundle\Entity\Tipo();
                        $tipo->setNombre($valor)
                            ->setAplicableA(ucfirst($entity));
                        $em->persist($tipo);
                    }
                    $obj->$set($tipo);
                    $em->persist($obj);
                    $tipo->$addName($obj);
                    $em->persist($tipo);
                    $em->flush();
                    $valores['datos'] = $obj->json(false);
                }elseif(strpos($nombre, 'incoterm') !== false){
                    $incoterm = $em->getRepository('PuertoUDESCommonBundle:Incoterm')
                        ->createQueryBuilder('i')
                        ->andWhere('i.canonical LIKE \'%'.$valor.'%\' OR i.nombre LIKE \'%'.$valor.'%\' OR i.sigla LIKE \'%'.$valor.'%\'')
                        ->getQuery()->getOneOrNullResult();
                    if(!$incoterm){
                        $incoterm = new \PuertoUDES\CommonBundle\Entity\Incoterm();
                        $anio = $request->get('anio',NULL);
                        if(!$anio)
                            $anio = 2010;
                        $incoterm
                            ->setCategoria(strtoupper($valor[0]))
                            ->setAnio($anio)
                            ->setSigla($valor)
                            ->setNombre($valor);
                        $em->persist($incoterm);
                    }
                    $obj->$set($incoterm);
                    $em->persist($obj);
                    $incoterm->$addName($obj);
                    $em->persist($incoterm);
                    $em->flush();
                    $valores['datos'] = $obj->json(false);
                }elseif(strpos($nombre, 'fecha') !== false){
                    $valor = date('Y-m-d H:i:s',strtotime($valor.' '.date('H:i:s')));
                    if($obj->$get()->format('Y-m-d H:i:s') != $valor){
                        $obj->$set(new \DateTime($valor));
                        $em->persist($obj);
                        $em->flush();
                        $valores['msgs'][] = array('msg' => 'Formato: El campo '.$nombre.' fué actualizado.', 'tipo' => 'success');
                        $valores['datos'] = $obj->json(false);
                    }else{
                        $valores['msgs'][] = array('msg' => 'Formato: El campo '.$nombre.' ya tenía éste valor.', 'tipo' => 'info');
                    }
                }elseif(strpos($nombre, 'moneda') !== false){
                    $moneda = $em->getRepository('PuertoUDESCommonBundle:Moneda')
                        ->createQueryBuilder('m')
                        ->andWhere('m.canonical LIKE \'%'.$valor.'%\' OR m.nombre LIKE \'%'.$valor.'%\' OR m.abreviacion LIKE \'%'.$valor.'%\'')
                        ->getQuery()->getOneOrNullResult();
                    if(!$moneda){
                        $moneda = new \PuertoUDES\CommonBundle\Entity\Moneda();
                        $moneda
                            ->setAbreviacion($valor)
                            ->setNombre(str_replace('-', ' ', $valor));
                        $em->persist($moneda);
                    }
                    $obj->$set($moneda);
                    $em->persist($obj);
                    $moneda->$addName($obj);
                    $em->persist($moneda);
                    $em->flush();
                    $valores['datos'] = $obj->json(false);
                }else{
                    if(method_exists($obj, $get) && $obj->$get() != $valor){
                        $obj->$set($valor);
                        $em->persist($obj);
                        $em->flush();
                        $valores['msgs'][] = array('msg' => 'Formato: El campo '.$nombre.' fué actualizado.', 'tipo' => 'success');
                        $valores['datos'] = $obj->json(false);
                    }else{
                        if(!method_exists($obj, $get)){
                            $valores['msgs'][] = array('msg' => 'Formato: Error obteniendo datos de '.$nombre.'.', 'tipo' => 'danger');
                        }else{
                            $valores['msgs'][] = array('msg' => 'Formato: El campo '.$nombre.' que tenía era el mismo.', 'tipo' => 'info');
                        }
                    }
                }
            }else{
                $valores['msgs'][] = array('msg' => 'Formato: Llena los demás datos y pulsa el botón guardar.', 'tipo' => 'warning');
            }
        }
        if(isset($valores['datos'])){
            if($entity == 'gasto' && $nombre == 'valor' && is_a($obj, 'PuertoUDES\FormatosBundle\Entity\Gasto')){
                $valores['datos'] = array_merge($valores['datos'],array(
                    'gastoRemitente' => $obj->getFormato()->getGastoTotalRemitente(),
                    'gastoDestinatario' => $obj->getFormato()->getGastoTotalDestinatario(),
                ));
            }elseif($nombre == 'pesoBruto'){
                $valores['datos'] = array_merge($valores['datos'],array(
                    'totalPesoBruto' => $obj->getFormato()->getTotalPesoBruto(),
                ));
            }elseif($nombre == 'pesoNeto'){
                $valores['datos'] = array_merge($valores['datos'],array(
                    'totalPesoNeto' => $obj->getFormato()->getTotalPesoNeto(),
                ));
            }elseif($nombre == 'volumen'){
                $valores['datos'] = array_merge($valores['datos'],array(
                    'totalVolumen' => $obj->getFormato()->getTotalVolumen(),
                ));
            }elseif($nombre == 'volumenOtro'){
                $valores['datos'] = array_merge($valores['datos'],array(
                    'totalVolumenOtro' => $obj->getFormato()->getTotalVolumenOtro(),
                ));
            }
        }
        return JsonResponse::create(array(
            'name'   =>    $nombre,
            'value'  =>    $valor,
            'pk'     =>    $llave,
            'save'   =>    $save,
            'entity' =>    $entity,
            'bundle' =>    $bundle,
            'values' =>    $valores,
        ));
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/CPIC/a/MCI/{numero_mci}/", name="formato_add_cpic_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Formato:_addCpicAjax.html.twig")
     */
    public function addCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $numero = $request->get('numero', -1);
        $numero_mci = $request->get('numero_mci', null);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'mci'));
        if($tipo_mci){
            $formato_mci = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero_mci));
            if($formato_mci){
                $formato = new Formato();
                $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic'));
                $formato->setTipo($tipo);
                $formato->setPadre($formato_mci);
                $formato->setNombre($tipo->getNombre().' de '.$formato_mci->getNombre());
                if($formato_mci->getTransportista()){
                    $formato->setTransportista($formato_mci->getTransportista());
                }
                $pesoBruto = $request->get('pesoBruto', null);
                $pesoNeto = $request->get('pesoNeto', null);
                if($numero > 0 && $pesoBruto >= $pesoNeto){
                    $formato->setNumero($numero);
                    $em->persist($formato);
                    $formato_mci->addHijo($formato);
                    $em->persist($formato_mci);
                    
                    $numBultos = $request->get('numBultos', null);
                    $volumen = $request->get('volumen', null);
                    $clase = $request->get('clase', null);
                    $marca = $request->get('marca', null);
                    $descripcion = $request->get('descripcion', null);
                    
                    $mercancia = $em->getRepository('PuertoUDESCommonBundle:Mercancia')
                            ->createQueryBuilder('m')
                            ->orWhere("m.descripcion LIKE '%".$descripcion."%'")
                            ->getQuery()->getOneOrNullResult();
                    if(!$mercancia){
                        $mercancia = new \PuertoUDES\CommonBundle\Entity\Mercancia();
                        $mercancia->setDescripcion($descripcion);
                        $em->persist($mercancia);
                    }
                    
                    $bulto = $em->getRepository('PuertoUDESCommonBundle:Bulto')
                            ->createQueryBuilder('b')
                            ->orWhere("b.clase LIKE '%".$clase."%'")
                            ->orWhere("b.marca LIKE '%".$marca."%'")
                            ->setMaxResults(1)
                            ->getQuery()->getOneOrNullResult();
                    if(!$bulto){
                        $bulto = new \PuertoUDES\CommonBundle\Entity\Bulto();
                        $bulto->setClase($clase)
                              ->setMarca($marca);
                        $em->persist($bulto);
                    }
                    $em->flush();
                    
                    $cmf = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')
                            ->createQueryBuilder('cmf')
                            ->andWhere("cmf.mercancia = ".$mercancia->getId())
                            ->andWhere("cmf.formato = ".$formato->getId())
                            ->andWhere("cmf.bulto = ".$bulto->getId())
                            ->getQuery()->getOneOrNullResult();
                    if(!$cmf){
                        $cmf = new \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato();
                        $cmf->setFormato($formato)
                            ->setMercancia($mercancia)
                            ->setBulto($bulto)
                            ->setPesoBruto($pesoBruto)
                            ->setPesoNeto($pesoNeto)
                            ->setVolumen($volumen)
                            ->setNumBultos($numBultos);
                        $em->persist($cmf);
                    }
                    $mercancia->addContenedoresFormato($cmf);
                    $bulto->addContenedorMercanciaFormato($cmf);
                    $em->persist($mercancia);
                    $em->persist($bulto);
                    $em->flush();
                    $datos['success']['msgs']['Formato'] = array(
                        'msg' => 'Formato de número <strong>"'.$formato->getNumero().'"</strong> con nombre <strong>"'.$formato->getNombre().'"</strong> fué creado',
                        'tipo' => 'success'
                    );
                    $datos['id'] = $formato->getId();
                    return JsonResponse::create($datos);
                }else{
                    
                }
            }
        }
        return array(
            'fila' => $filas,
            'numero' => $numero_mci,
            'formato' => $formato,
        );
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Guardar/{tipo}/", name="formato_save_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveAjaxAction(Request $request){
        $tipo = $request->get('tipo',NULL);
        $nombre = $request->get('nombre',NULL);
        $descripcion = $request->get('descripcion',NULL);
        $numero = $request->get('numero',NULL);
        $em = $this->getDoctrine()->getManager();
        $datos = array(
            'errors' => array(),
        );
        if(is_numeric($numero)){
            $formato = $this->getRepositorio()->findOneBy(array('numero' => $numero));
            if(!$formato){
                $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $tipo));
                if($tipo){
                    $formato = new Formato();
                    $formato->setNombre($nombre);
                    $formato->setDescripcion($descripcion);
                    $formato->setNumero($numero);
                    $formato->setTipo($tipo);
                    $em->persist($formato);
                    $em->flush();
                    $datos['success']['msgs']['Formato'] = array(
                        'msg' => 'Formato de número <strong>"'.$formato->getNumero().'"</strong> con nombre <strong>"'.$formato->getNombre().'"</strong> fué creado',
                        'tipo' => 'success'
                    );
                    $datos['id'] = $formato->getId();
                }
                else{
                    $datos['errors']['Formato'] = 'Tipo de formato no encontrado.';
                }
            }
            else{
                $datos['errors']['Formato'] = 'El formato ya existe';
            }
        }
        else{
            $datos['errors']['Número de '.$tipo] = 'El Número de Formato ya existe';
        }
        return JsonResponse::create($datos);
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/nuevo/{abrevia}", name="formato__new_")
     * @Route("/nuevo/", name="formato__new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction($abrevia = null)
    {
        $entity = new Formato();
        $em = $this->getDoctrine()->getManager();
        $tipo = null;
        if(!is_null($abrevia))
            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($abrevia)));
        $numero = $this->getRepositorio()->countFormatos()+1;
//        $entity->setNumero($numero);
        if($tipo){
            $entity->setTipo($tipo);
            $datos = array(
                'entity' => $entity,
            );
            $entity->setNombre($tipo->getNombre().' '.$numero);
        }
//        else{
//            throw $this->createNotFoundException('No encontrado el Tipo de Formato.');
//        }
        $form   = $this->createCreateForm($entity);

        $datos['form'] = $form->createView();

        if($this->getRequest()->isXmlHttpRequest()){
            $datos['claseContentForm'] = 'text-center';
            return JsonResponse::create (array(
                    'ajaxForm'  =>   false,
                    'title'     =>   'Agregar Formato '.($tipo?$tipo->getNombre():''),
                    'body'      =>   $this->renderView('PuertoUDESCommonBundle:Plantilla:_new.html.twig', $datos)
                ));
        }
        return $datos;
    }

    /**
     * Finds and displays a Formato entity.
     *
     * @Route("/{id}", name="formato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
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
                'body'  => $this->renderView('PuertoUDESFormatosBundle:Formato:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Formato entity.
     *
     * @Route("/{id}/edit", name="formato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
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
                'body'  => $this->renderView('PuertoUDESFormatosBundle:Formato:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Formato entity.
     *
     * @Route("/{id}", name="formato__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Formato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Formato entity.
     *
     * @Route("/{id}", name="formato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formato_'));
    }

    /**
     * Creates a form to delete a Formato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formato__delete', array('id' => $id)))
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
     * @return FormatoRepository  FormatoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:Formato');
    }
    
    public function getHeadFiltro($form, $route, $tipo = true){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'    =>   'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Descripcion',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'  =>   'canonical',
                        'label' =>   'Autor',
                        'join'  =>   'autor',
                        'class' =>  'text-center',
                    ),
                )
            ),
        );
        if(is_bool($tipo) && $tipo){
            $filas[0]['col'][] = array(
                'dato'    =>   'nombre',
                'label'    =>   'Tipo de Formato',
                'join'    =>   'tipo',
                'class' =>  'text-center',
            );
        }
        $filas[0]['col'][] = array(
            'dato'    =>   'Acciones',
            'class' =>  'text-center',
            'acciones'=>    array(
                array(
                    'url'   => 'formato__edit',
                    'class' =>  'no-ajax',
                    'data_url'=> array('id'),
                    'type'  => 'default',
                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                ),
                array(
                    'url'   => 'formato__delete',
                    'data_url'=> array('id'),
                    'type'  => 'danger',
                    'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                ),
            )
        );
        return $this->getUtils()->getHeadFiltro($filas, $form, $route);
    }
}
