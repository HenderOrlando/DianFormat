<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\CommonBundle\Entity\Aduana;
use PuertoUDES\CommonBundle\Form\AduanaType;

/**
 * Aduana controller.
 *
 * @Route("/Aduana")
 */
class AduanaController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_aduanas_")
     * @Route("/{tipo}/Lista/para/{name}/", name="list_typeahead_aduanas")
     * @Template("PuertoUDESFormatosBundle:Formato:_addAduanaMciAjax.html.twig")
     */
    public function listTypeahead(Request $request){
        $list = array();
        $entities = array();
        $name = $request->get('name','');
        $tipo = $request->get('tipo','');
        switch(strtolower($tipo)){
            case 'destino':
                $entities = $this->getRepositorio()->getDestino();
                break;
            case 'cruce-de-frontera':
                $entities = $this->getRepositorio()->getCruce();
                break;
            case 'partida':
                $entities = $this->getRepositorio()->getPartida();
                break;
            default:
                $entities = $this->getRepositorio()->findAll();
                break;
        }
        $propertyPath = new PropertyAccessor();
        foreach($entities as $aduana){
            $value = $propertyPath->getValue($aduana,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $aduana->getTokens(),
                'datos' =>  $aduana->json(false)
            );
        }
        return JsonResponse::create($list);
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/{tipo}/a/MCI-{fila}/{numero}/", name="aduana_add_mci_ajax_")
     * @Route("/Agregar/{tipo}/a/MCI/{numero}/", name="aduana_add_mci_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESCommonBundle:Aduana:_addAduanaMciAjax.html.twig")
     */
    public function addAduanaMciAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('nombre',NULL);
        $docId = $request->get('docId',NULL);
        $direccion = $request->get('direccion','');
        $lugar = $request->get('lugar',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'mci'));
        $aduana = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($docId && $nombre){
                    $aduana = $this->getRepositorio()->createQueryBuilder('e')
                        ->leftJoin('e.usuario', 'u')
                        ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                        ->andWhere("u.docId= '".$docId."'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$aduana){
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
                        $aduana = new Entidad();
                        $aduana->setUsuario($u->setEntidad($aduana));
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
                                $aduana->setLugar($l);
                                $l->addEntidad($aduana);
                                $em->persist($l);
                        }
                        $u->setEntidad($aduana);
                        $em->persist($u);
                        $em->persist($aduana);
                    }else{
                        $u = $aduana->getUsuario();
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
                        $em->flush();
                        $datos['success']['msgs']['Formato'] = array(
                            'msg' => 'Entidad '.($role == 'notificar'?'a notificar':str_replace('tario', 'taria', $role)).' <strong>"'.$aduana->getNombre().'"</strong> agregada.',
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
            'aduana'       =>  $aduana,
            'tipo'           =>  $tipo,
        );
    }
    
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Reset/{tipoAduana}/a/{abreviacion}-{fila}/{numero}/", name="aduana_add_mci_ajax_reset_")
     * @Route("/Reset/{tipoAduana}/a/{abreviacion}/{numero}/", name="aduana_add_mci_ajax_reset")
     * @Route("/Reset/{tipo}/a/{abreviacion}-{fila}/{numero}/", name="aduana_add_mci_ajax_reset_tipo_")
     * @Route("/Reset/{tipo}/a/{abreviacion}/{numero}/", name="aduana_add_mci_ajax_reset_tipo")
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
                        'msg' => 'Imposible de limpiar',
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
     * Lists all Aduana entities.
     *
     * @Route("/", name="aduana_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Aduanas';
        $entity = 'Aduana';
        $bundle = 'Common';
        $route = 'aduana_';
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
            array(
                'url'   => $this->generateUrl('aduana__new'),
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
     * Creates a new Aduana entity.
     *
     * @Route("/", name="aduana__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Aduana:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Aduana();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aduana__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Aduana entity.
    *
    * @param Aduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Aduana $entity)
    {
        $form = $this->createForm(new AduanaType(), $entity, array(
            'action' => $this->generateUrl('aduana__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Aduana entity.
     *
     * @Route("/new", name="aduana__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Aduana();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Aduana entity.
     *
     * @Route("/{id}", name="aduana__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Aduana entity.
     *
     * @Route("/{id}/edit", name="aduana__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
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
    * Creates a form to edit a Aduana entity.
    *
    * @param Aduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Aduana $entity)
    {
        $form = $this->createForm(new AduanaType(), $entity, array(
            'action' => $this->generateUrl('aduana__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Aduana entity.
     *
     * @Route("/{id}", name="aduana__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Aduana:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aduana__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Aduana entity.
     *
     * @Route("/{id}", name="aduana__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Aduana entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aduana_'));
    }

    /**
     * Creates a form to delete a Aduana entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aduana__delete', array('id' => $id)))
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Aduana');
    }
    
    public function getHeadFiltro($form, $route){
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
                        'label'  =>   'Lugar',
                        'join'  =>  'lugar',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'moneda__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'moneda__delete',
                                'data_url'=> array('id'),
                                'type'  => 'danger',
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
