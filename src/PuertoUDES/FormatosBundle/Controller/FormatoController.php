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
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Formatos';
        $entity = 'Formato';
        $bundle = 'Formato';
        $route = 'formato_';
        $limit = 5;
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
            ),
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
            'datos_form'       =>  $data,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render('FormatEasyCommonBundle:Plantilla:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Lists all Formato entities.
     *
     * @Route("/CPIC/", name="formato__cpic")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function cpicAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Carta de Porte Internacional por Carretera',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'cpic',
            'route'     =>  'formato__cpic',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getCpic(null, false, true),
        ));
    }
    /**
     * Lists all Formato entities.
     *
     * @Route("/MCI/", name="formato__mci")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function mciAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Manifiesto de Carga Internacional',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'mci',
            'route'     =>  'formato__mci',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getMci(null, false, true),
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
            $em->flush();

            return $this->redirect($this->generateUrl('formato__show', array('id' => $entity->getId())));
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
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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
            if($obj){
                if(strpos($nombre, 'lugar') !== false){
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
                }else{
                    if($obj->$get() != $valor){
                        $obj->$set($valor);
                        $em->persist($obj);
                        $em->flush();
                        $valores['msgs'][] = array('msg' => $entity.': El '.$nombre.' fué actualizado.', 'tipo' => 'success');
                        $valores['datos'] = $obj->json();
                    }else{
                        $valores['msgs'][] = array('msg' => $entity.': El '.$nombre.' ya tenía éste valor.', 'tipo' => 'info');
                    }
                }
            }else{
                $valores['msgs'][] = array('msg' => $entity.': Llena los demás datos y pulsa el botón guardar.', 'tipo' => 'warning');
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
                $formato->setNombre($tipo->getNombre().' de '. $formato_mci->getNombre());
                if($numero > 0){
                    $formato->setNumero($numero);
                    $em->persist($formato);
                    $formato_mci->addHijo($formato);
                    $em->persist($formato_mci);
                    
                    $numBultos = $request->get('numBultos', null);
                    $pesoBruto = $request->get('pesoBruto', null);
                    $pesoNeto = $request->get('pesoNeto', null);
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
     * @Method("GET")
     * @Template()
     */
    public function newAction($abrevia = null)
    {
        $entity = new Formato();
        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($abrevia?$abrevia:'mci')));
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
//        $form   = $this->createCreateForm($entity);
//
//        $datos['form'] = $form->createView();

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

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
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

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
                )
            ),
        );
        if(is_bool($tipo) && $tipo){
            $filas[0]['col'][] = array(
                'dato'    =>   'canonical',
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
