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
     * @Route("/Agregar/{tipo}/a/DTAI-{fila}/{numero}/", name="aduana_add_remesa_ajax_")
     * @Route("/Agregar/{tipo}/a/DTAI/{numero}/", name="aduana_add_remesa_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESCommonBundle:Aduana:_addAduanaRemesaAjax.html.twig")
     */
    public function addAduanaRemesaAjaxAction(Request $request){
        return $this->addAduanaMciAjaxAction($request, 'remesa');
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/{tipo}/a/DTAI-{fila}/{numero}/", name="aduana_add_dtai_ajax_")
     * @Route("/Agregar/{tipo}/a/DTAI/{numero}/", name="aduana_add_dtai_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESCommonBundle:Aduana:_addAduanaMciAjax.html.twig")
     */
    public function addAduanaDtaiAjaxAction(Request $request){
        return $this->addAduanaMciAjaxAction($request, 'dtai');
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/{tipo}/a/DI-{fila}/{numero}/", name="aduana_add_di_ajax_")
     * @Route("/Agregar/{tipo}/a/DI/{numero}/", name="aduana_add_di_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESCommonBundle:Aduana:_addAduanaMciAjax.html.twig")
     */
    public function addAduanaDiAjaxAction(Request $request){
        return $this->addAduanaMciAjaxAction($request, 'dtai');
    }
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Agregar/{tipo}/a/MCI-{fila}/{numero}/", name="aduana_add_mci_ajax_")
     * @Route("/Agregar/{tipo}/a/MCI/{numero}/", name="aduana_add_mci_ajax")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESCommonBundle:Aduana:_addAduanaMciAjax.html.twig")
     */
    public function addAduanaMciAjaxAction(Request $request, $abreviacion = 'mci'){
        $filas = $request->get('filas', 0);
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('name',NULL);
        $valor = $request->get('value',NULL);
        $llave = $request->get('pk',NULL);
        $lugar = $request->get('lugar',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $abreviacion));
        $aduana = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($nombre || $llave && $valor){
                    $aduana = $this->getRepositorio()->find($llave);
                    $existe_aduana = true;
                    if(!$aduana){
                        $existe_aduana = false;
                        $aduana = new Aduana();
                        if($nombre === 'lugar'){
                            $lugar = $valor;
                        }
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
                                $em->persist($l);
                                $em->persist($aduana);
                                $aduana->setLugar($l);
                                $l->addAduana($aduana);
                                $em->persist($l);
                        }
                        $aduana->setNombre('Aduana de '.$lugar);
                        $em->persist($aduana);
                    }
                    $nivel = $em->getRepository('PuertoUDESCommonBundle:Tipo')
                            ->createQueryBuilder('t')
                            ->andWhere('t.canonical LIKE \'%'.$tipo.'%\' OR t.nombre LIKE \'%'.$tipo.'%\'')
                            ->getQuery()->getOneOrNullResult();
                    if($nivel){
                        if($existe_aduana){
                            $fa = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(
                                array(
                                    'nivel' => $nivel,
                                    'aduana' => $aduana,
                                    'formato' => $formato
                                ));
                        }else{
                            $fa = null;
                        }
                        if(!$fa){
                            $fa = new \PuertoUDES\FormatosBundle\Entity\FormatoAduana();
                            $fa->setAduana($aduana)
                                ->setFormato($formato)
                                ->setNivel($nivel);
                            $em->persist($fa);
                        }
                        $datos['success']['msgs']['Aduana'] = array(
                            'msg' => 'Aduana '.' <strong>"'.$aduana->getNombre().'"</strong> agregada.',
                            'tipo' => 'success'
                        );
                        $em->flush();
                        $datos['id'] = $aduana->getId();
                        $datos['datos'] = $aduana->json(false);
                        return JsonResponse::create($datos);
                    }else{
                        $datos['errors']['Formato'] = 'Nivel de Aduana no encontrado';
                        if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT'){
                            return JsonResponse::create($datos);
                        }
                    }
                }else{
                    $datos['errors']['Formato'] = 'Llene los campos antes de guardar';
                    if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT'){
                        return JsonResponse::create($datos);
                    }
                }
            }else{
                $datos['errors']['Formato'] = 'Formato no válido';
                if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT'){
                    return JsonResponse::create($datos);
                }
            }
        }else{
            $datos['errors']['Tipo de Formato'] = 'Llene los campos antes de guardar';
            if($request->isXmlHttpRequest() && strtoupper($request->getMethod()) === 'PUT'){
                return JsonResponse::create($datos);
            }
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
                    if(strtolower($entity) == 'aduana'){
                        $find = array('formato' => $formato, strtolower($entity) => $obj);
                        if(is_string($tipo)){
                            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->createQueryBuilder('t')
                                    ->andWhere("t.canonical LIKE '%".$tipo."%' OR t.nombre LIKE '%".$tipo."%' OR t.abreviacion LIKE '%".$tipo."%'")
                                    ->getQuery()->getOneOrNullResult();
                            if($tipo)
                                $find = array_merge($find,array('tipo' => $tipo));
                        }
//                        var_dump($find);
//                        die;
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:'.$repository)->findOneBy($find);
//                        $formato->$remove($fu);
//                        $obj->removeFormato($fu);
                        $em->remove($fu);
                        $em->flush();
//                        $formato->$remove($fu);
//                        $obj->removeFormato($fu);
                        $datos['msgs']['Aduana'] = array(
                            'msg' => 'Eliminado'.($role?' '.$role.' ':' ').$obj->__toString(),
                            'tipo' => 'success'
                        );
                    }else{
                        $datos['msgs']['Aduana'] = array(
                            'msg' => 'Imposible de limpiar '.$entity,
                            'tipo' => 'danger'
                        );
                    }
                }else{
                    $datos['msgs']['Formato'] = array(
                        'msg' => 'Objeto no válido',
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
                'class'  => 'carga-modal',
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

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nueva Aduana',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
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

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            $title = empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre();
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Aduana:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
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

        $template = 'edit';
        $parametros = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            $title = empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre();
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
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
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'moneda__delete',
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
