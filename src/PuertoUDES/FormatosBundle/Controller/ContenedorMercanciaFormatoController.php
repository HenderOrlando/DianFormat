<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\CommonBundle\Entity\Bulto;
use PuertoUDES\CommonBundle\Entity\Mercancia;
use PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato;
use PuertoUDES\FormatosBundle\Form\ContenedorMercanciaFormatoType;

/**
 * ContenedorMercanciaFormato controller.
 *
 * @Route("/ContenedorMercanciaFormato")
 */
class ContenedorMercanciaFormatoController extends Controller
{
    
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_contenedorMercanciaFormato_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = array();
        $name = $request->get('name','');
        $em = $this->getDoctrine()->getManager();
        switch(strtolower($name)){
            case 'marca':
            case 'clase':
                $entities = $em->getRepository('PuertoUDESCommonBundle:Bulto')->findAll();
                break;
            case 'descripcion':
                $entities = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->findAll();
                break;
            default:
                $entities = $this->getRepositorio()->findAll();
                break;
        }
        $propertyPath = new PropertyAccessor();
        foreach($entities as $cmf){
            $value = $propertyPath->getValue($cmf,$name);
            if(is_null($value)){
                $value = '';
            }
            elseif(is_object($value)){
                $value = $value->__toString();
            }
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $cmf->getTokens(),
                'datos' =>  $cmf->json(false)
            );
        }
        return JsonResponse::create($list);
    }
    
    /**
     * Lists all ContenedorMercanciaFormato entities.
     *
     * @Route("/", name="contenedorMercanciaFormato_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ContenedorMercanciaFormato entity.
     *
     * @Route("/", name="contenedorMercanciaFormato__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:ContenedorMercanciaFormato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ContenedorMercanciaFormato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenedorMercanciaFormato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ContenedorMercanciaFormato entity.
    *
    * @param ContenedorMercanciaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ContenedorMercanciaFormato $entity)
    {
        $form = $this->createForm(new ContenedorMercanciaFormatoType(), $entity, array(
            'action' => $this->generateUrl('contenedorMercanciaFormato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContenedorMercanciaFormato entity.
     *
     * @Route("/new", name="contenedorMercanciaFormato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContenedorMercanciaFormato();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}/edit", name="contenedorMercanciaFormato__edit")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'body'   =>   $this->renderView ('PuertoUDESFormatosBundle:ContenedorMercanciaFormato:_edit.html.twig', $datos),
                'title'  =>   'Editando '.$entity->getMercancia()->__toString(),
            ));
        }
        return $datos;
    }

    /**
    * Creates a form to edit a ContenedorMercanciaFormato entity.
    *
    * @param ContenedorMercanciaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContenedorMercanciaFormato $entity)
    {
        $form = $this->createForm(new ContenedorMercanciaFormatoType(), $entity, array(
            'action' => $this->generateUrl('contenedorMercanciaFormato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:ContenedorMercanciaFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            
            if(!$request->isXmlHttpRequest())
                return $this->redirect($this->generateUrl('contenedorMercanciaFormato__edit', array('id' => $id)));
        }
        
        $datos = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        if($request->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'body'  =>  $this->renderView ('PuertoUDESFormatosBundle:ContenedorMercanciaFormato:_edit.html.twig', $datos),
                'title' =>  'Editando '.$entity->getMercancia()->__toString(),
                'datos' => array_merge($entity->json(false),array(
                    'pesoBruto'     =>  $entity->getFormato()->getTotalPesoBruto(),
                    'pesoNeto'      =>  $entity->getFormato()->getTotalPesoNeto(),
                    'volumen'       =>  $entity->getFormato()->getTotalVolumen(),
                    'volumenOtro'   =>  $entity->getFormato()->getTotalVolumenOtro(),
                )),
            ));
        }
        return $datos;
    }
    /**
     * Deletes a ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenedorMercanciaFormato_'));
    }

    /**
     * Creates a form to delete a ContenedorMercanciaFormato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contenedorMercanciaFormato__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/Agregar-Gasto/a/{str_tipo}/{numero}/", name="mercanciaGastoFormato_add_tipo_ajax")
     * @Route("/Gasto-{pk}/en/{str_tipo}-{numero}/{fila}/", name="mercanciaGastoFormato_add_tipo_ajax_")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Formato:_addMercanciaGastoAjax.html.twig")
     */
    public function addMercanciaGastoFormatoAjaxAction(Request $request){
        
        // Falta agregar el tratamiento de los datos para el gasto
        
        $filas = $request->get('filas', 0);
        $pk = $request->get('pk', -1);
        $numero = $request->get('numero',NULL);
        $cantidad = $request->get('numBultos',NULL);
        $unidad = $request->get('unidadBultos',NULL);
        $clase = $request->get('clase',NULL);
        $marca = $request->get('marca',NULL);
        $descripcion = $request->get('descripcion',NULL);
        $concepto = $request->get('concepto',NULL);
        $valor = $request->get('valor',NULL);
        $moneda = $request->get('moneda',NULL);
        $rolUsuario = $request->get('rolUsuario',NULL);
        $em = $this->getDoctrine()->getManager();
        $str_tipo = $request->get('str_tipo','cpic');
        $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $str_tipo, 'aplicableA' => 'Formato'));
        $cm = null;
        $datos = array();
        
        if($tipo){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo->getId(), 'numero' => $numero));
            if($formato){
                if(is_numeric($cantidad) /*&& is_string($clase)*/ && is_string($descripcion)){
                    if($pk < 0)
                        $cm = NULL;
                    else
                        $cm = $this->getRepositorio()->find($pk);
                        
//                    $cm = $this->getRepositorio()->createQueryBuilder('cm')
//                        ->innerJoin("cm.mercancia",'m')
//                        ->andWhere("cm.formato=".$formato->getId())
//                        ->andWhere("cm.numBultos=".$cantidad)
//                        ->andWhere("m.descripcion LIKE '%".$descripcion."%'")
//                        ->getQuery()->getOneOrNullResult();
                    if(!$cm){
                        $cm = new ContenedorMercanciaFormato();
                        $cm->setFormato($formato);
                        $em->persist($cm);
                    }
                    $cm ->setNumBultos($cantidad);
                    $mercancia = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->createQueryBuilder('m')
                        ->andWhere("m.descripcion LIKE '%".$descripcion."%'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$mercancia){
                        $mercancia = new Mercancia();
                        $mercancia->setDescripcion($descripcion)
                            ->addContenedoresFormato($cm);
                            $em->persist($mercancia);
                    }
                    $cm->setMercancia($mercancia);
                    // Gasto
                    $error = false;
                    if($concepto && !is_null($valor)){
                        $unidad = $em->getRepository('PuertoUDESCommonBundle:Unidad')->createQueryBuilder('u')
                            ->andWhere("u.nombre LIKE '%".$unidad."%' OR u.abreviacion LIKE '%".$unidad."%' OR u.canonical LIKE '%".$unidad."%' OR u.canonicalAbreviacion LIKE '%".$unidad."%'")
                            ->getQuery()->getOneOrNullResult();
                        if($unidad){

                            $cm ->setUnidad($unidad);
                        }else{
    //                        $unidad = new Unidad();
    //                        $unidad->setClase($clase)
    //                            ->addContenedorMercanciaFormato($cm);
    //                        $em->persist($unidad);
                            $error = true;
                            $datos['errors']['Formato'] = 'Datos inválidos. Moneda no encontrada.';
                        }
                        $tipoGasto = $em->getRepository('PuertoUDESCommonBundle:Tipo')->createQueryBuilder('t')
                                ->andWhere("t.canonical LIKE '%".$concepto."%' OR t.nombre LIKE '%".$concepto."%' OR t.abreviacion LIKE '%".$concepto."%'")
                                ->andWhere("t.aplicableA LIKE '%gasto%'")
                                ->getQuery()->getOneOrNullResult();
                        if(!$tipoGasto){
                            $tipoGasto = new \PuertoUDES\CommonBundle\Entity\Tipo();
                            $tipoGasto
                                    ->setAplicableA('Gasto')
                                    ->setNombre(str_replace('-',' ',str_replace('_', ' ', $concepto)))
                                    ->setAbreviacion(str_replace('-',' ',str_replace('_', ' ', $concepto)));
                            $em->persist($tipoGasto);
                            $em->flush();
                        }
                        $usuario = null;
                        if($rolUsuario){
                            $rolUsuario = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                                    ->andWhere("r.canonical LIKE '%".$rolUsuario."%' OR r.nombre LIKE '%".$rolUsuario."%'")
                                    ->andWhere("r.aplicableA LIKE '%formatoUsuario%'")
                                    ->getQuery()->getOneOrNullResult();
                            if(!$rolUsuario){
                                $datos['errors']['Formato'] = 'Datos inválidos. Rol de Usuario no encontrado.';
                                //Rol no existe
    //                            $error = true;
                            }else{
                                $usuario = $formato->getUsuarios($rolUsuario->getCanonical());
                                if(!empty($usuario) && isset($usuario[0]) && is_a($usuario[0]->getUsuario(),'PuertoUDES\UsuariosBundle\Entity\Usuario'))
                                    $usuario = $usuario[0]->getUsuario();
                            }
                        }
                        if($moneda){
                            $moneda = $em->getRepository('PuertoUDESCommonBundle:Moneda')->createQueryBuilder('m')
                                    ->andWhere("m.canonical LIKE '%".$moneda."%' OR m.nombre LIKE '%".$moneda."%' OR m.abreviacion LIKE '%".$moneda."%'")
                                    ->getQuery()->getOneOrNullResult();
                            if(!$moneda){
                                $datos['errors']['Formato'] = 'Datos inválidos. Moneda no encontrada.';
                                //Moneda no existe
                                $error = true;
                            }
                        }
                        if(!$error){
                            $q = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->createQueryBuilder('g')
                                ->innerJoin('g.concepto', 't')
                                ->andWhere("g.formato =".$formato->getId())
                                ->andWhere("t.canonical LIKE '%".$concepto."%' OR t.nombre LIKE '%".$concepto."%' OR t.abreviacion LIKE '%".$concepto."%'")
                                ->andWhere("t.id = ".$tipoGasto->getId());
                            if($rolUsuario){
                                $q->andWhere('g.rolUsuario='.$rolUsuario->getId());
                            }
                            $gasto = $q->getQuery()->getOneOrNullResult();
                            if(!$gasto){
                                $gasto = new \PuertoUDES\FormatosBundle\Entity\Gasto();
                                $gasto
                                        ->setValor($valor)
                                        ->setFormato($formato)
                                        ->setConcepto($tipoGasto);
                                $em->persist($gasto);
                            }
                            $gasto->setMercancia($mercancia);
                            $tipoGasto->addGasto($gasto);
                            $formato->addGasto($gasto);
                            if($usuario && is_a($usuario, 'PuertoUDES\UsuariosBundle\Entity\Usuario')){
                                $gasto->setUsuario($usuario);
                                $em->persist($gasto);
                                $usuario->addGasto($gasto);
                                $em->persist($usuario);
                            }
                            if($moneda){
                                $gasto->setMoneda($moneda);
                                $em->persist($gasto);
                                $moneda->addGasto($gasto);
                                $em->persist($moneda);
                            }
                            if($rolUsuario){
                                $gasto->setRolUsuario($rolUsuario);
                                $em->persist($gasto);
                                $rolUsuario->addGasto($gasto);
                                $em->persist($rolUsuario);
                            }
                        }
                    }else{
                        $error = true;
                    }
                    
                    if(!$error){
                        $em->persist($tipoGasto);
                        $em->persist($formato);
                        $em->persist($unidad);
                        $em->persist($mercancia);
                        $em->persist($cm);
                        $em->flush();
                        $datos = array(
//                            'errors'   =>  array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Información guardada','tipo' => 'success'))),
                            'success'   =>  array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Información guardada','tipo' => 'success'))),
                            'datos'     =>  array(
                                    'pesoBruto'     =>  $cm->getFormato()->getTotalPesoBruto(),
                                    'pesoNeto'      =>  $cm->getFormato()->getTotalPesoNeto(),
                                    'volumen'       =>  $cm->getFormato()->getTotalVolumen(),
                                    'volumenOtro'   =>  $cm->getFormato()->getTotalVolumenOtro(),
                                ),
                            'url'       =>  $this->generateUrl('contenedorMercanciaFormato__edit', array('id' => $cm->getId())),
                            'id'        =>  $cm->getId(),
                        );
                    }else{
                        $datos['errors']['Mercancia Factura'] = 'Parece hay errores en el '.$formato->getTipo()->getAbreviacion();
                    }
                    
                }else{
                    $datos['errors'] = $filas;
                    if(!$filas && $request->isXmlHttpRequest() && $request->getMethod() != 'POST'){
                        $datos['errors'] = array();
                        $datos['errors']['Contenedor Mercancia'] = 'Datos incompletos, Son necesarios Precio, Moneda, Cantidad, Unidad y Descripción de las Mercancias';
                    }
                }
                if(!$filas){
                    return JsonResponse::create($datos);
                }
            }else{
                $datos['errors']['Contenedor Mercancias'] = 'Datos no válidos';
                return JsonResponse::create($datos);
            }
        }
        return array(
            'fila'         =>  $filas,
            'formato'      =>  $formato,
            'cm'           =>  $cm,
        );
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/Reset-Gasto/a/CPIC/{numero}/", name="mercanciaGastoFormato_reset_cpic_ajax")
     * @Route("/Gasto-{pk}/en/CPIC-{numero}/{fila}/", name="mercanciaGastoFormato_reset_cpic_ajax_")
     * @Route("/Reset-Gasto/a/{str_tipo}/{numero}/", name="mercanciaGastoFormato_reset_tipo_ajax")
     * @Route("/Gasto-{pk}/en/{str_tipo}-{numero}/{fila}/", name="mercanciaGastoFormato_reset_tipo_ajax_")
     * @Method({"DELETE"})
     * @Template("")
     */
    public function resetMercanciaGastoFormatoCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $pk = $request->get('pk', -1);
        $numero = $request->get('numero',NULL);
        $em = $this->getDoctrine()->getManager();
        $str_tipo = $request->get('str_tipo','');
        
        $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic', 'aplicableA' => 'Formato'));
        $cm = null;
        $datos = array();
        if($tipo){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo->getId(), 'numero' => $numero));
            if($formato){
                if(is_numeric($pk) && $pk >= 0){
                    $cm = $this->getRepositorio()->find($pk);
                    if($cm){
                        $em->remove($cm);
                        $em->flush();
                    }
                    $success = array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Mercancía "'.$cm->getMercancia()->__toString().'" removida del Formato','tipo' => 'success')));
                }
                else{
                    $success = array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Datos No Válidos!!','tipo' => 'danger')));
                }
                $datos = array(
                    'success'   =>  $success,
                    'datos'     =>  array(
                            'pesoBruto'     =>  $formato->getTotalPesoBruto(),
                            'pesoNeto'      =>  $formato->getTotalPesoNeto(),
                            'volumen'       =>  $formato->getTotalVolumen(),
                            'volumenOtro'   =>  $formato->getTotalVolumenOtro(),
                        ),
                );
                return JsonResponse::create($datos);
            }else{
                $datos['errors']['Contenedor Mercancias'] = 'Datos no válidos';
                return JsonResponse::create($datos);
            }
        }
        return array(
            'fila'         =>  $filas,
            'formato'      =>  $formato,
            'cm'           =>  $cm,
        );
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/Agregar/a/{str_tipo}/{numero}/", name="contenedorMercanciaFormato_add_tipo_ajax")
     * @Route("/{pk}/en/{str_tipo}-{numero}/{fila}/", name="contenedorMercanciaFormato_add_tipo_ajax_")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Formato:_addContenedorMercanciaAjax.html.twig")
     */
    public function addcontenedorMercanciaFormatoCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $pk = $request->get('pk', -1);
        $numero = $request->get('numero',NULL);
        $cantidad = $request->get('numBultos',NULL);
        $clase = $request->get('clase',NULL);
        $marca = $request->get('marca',NULL);
        $descripcion = $request->get('descripcion',NULL);
        $em = $this->getDoctrine()->getManager();
        $str_tipo = $request->get('str_tipo','cpic');
        $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $str_tipo, 'aplicableA' => 'Formato'));
        $cm = null;
        $datos = array();
        if($tipo){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo->getId(), 'numero' => $numero));
            if($formato){
                if(is_numeric($cantidad) && is_string($clase) && is_string($marca) && is_string($descripcion)){
                    if($pk < 0)
                        $cm = NULL;
                    else
                        $cm = $this->getRepositorio()->find($pk);
                        
//                    $cm = $this->getRepositorio()->createQueryBuilder('cm')
//                        ->innerJoin("cm.mercancia",'m')
//                        ->andWhere("cm.formato=".$formato->getId())
//                        ->andWhere("cm.numBultos=".$cantidad)
//                        ->andWhere("m.descripcion LIKE '%".$descripcion."%'")
//                        ->getQuery()->getOneOrNullResult();
                    if(!$cm){
                        $cm = new ContenedorMercanciaFormato();
                        $cm->setFormato($formato);
//                        $em->persist($cm);
                    }
                    $cm ->setNumBultos($cantidad);
                    $mercancia = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->createQueryBuilder('m')
                        ->andWhere("m.descripcion LIKE '%".$descripcion."%'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$mercancia){
                        $mercancia = new Mercancia();
                        $mercancia->setDescripcion($descripcion)
                            ->addContenedoresFormato($cm);
//                            $em->persist($mercancia);
                    }
                    $cm->setMercancia($mercancia);
                    $bulto = $em->getRepository('PuertoUDESCommonBundle:Bulto')->createQueryBuilder('b')
                        ->andWhere("b.clase LIKE '%".$clase."%'")
                        ->andWhere("b.marca LIKE '%".$marca."%'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$bulto){
                        $bulto = new Bulto();
                        $bulto->setMarca($marca)
                            ->setClase($clase)
                            ->addContenedorMercanciaFormato($cm);
//                        $em->persist($bulto);
                    }
                    $cm ->setBulto($bulto);
                    $em->persist($bulto);
                    $em->persist($mercancia);
                    $em->persist($cm);
                    $em->flush();
                    $datos = array(
                        'success'   =>  array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Información guardada','tipo' => 'success'))),
                        'datos'     =>  array(
                                'pesoBruto'     =>  $cm->getFormato()->getTotalPesoBruto(),
                                'pesoNeto'      =>  $cm->getFormato()->getTotalPesoNeto(),
                                'volumen'       =>  $cm->getFormato()->getTotalVolumen(),
                                'volumenOtro'   =>  $cm->getFormato()->getTotalVolumenOtro(),
                            ),
                        'url'       =>  $this->generateUrl('contenedorMercanciaFormato__edit', array('id' => $cm->getId())),
                        'id'        =>  $cm->getId(),
                    );
                    return JsonResponse::create($datos);
                }else{
                    if($request->isXmlHttpRequest() && $request->getMethod() != 'POST')
                        $datos['errors']['Contenedor Mercancia'] = 'Datos incompletos, Son necesarios Cantidad, Clase y Marca de los Bultos y Descripción de Mercancias';
                }
            }else{
                $datos['errors']['Contenedor Mercancias'] = 'Datos no válidos';
                return JsonResponse::create($datos);
            }
        }
        return array(
            'fila'         =>  $filas,
            'formato'      =>  $formato,
            'cm'           =>  $cm,
        );
    }
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/Reset/a/CPIC/{numero}/", name="contenedorMercanciaFormato_reset_cpic_ajax")
     * @Route("/{pk}/en/CPIC-{numero}/{fila}/", name="contenedorMercanciaFormato_reset_cpic_ajax_")
     * @Route("/Reset/a/{str_tipo}/{numero}/", name="contenedorMercanciaFormato_reset_tipo_ajax")
     * @Route("/{pk}/en/{str_tipo}-{numero}/{fila}/", name="contenedorMercanciaFormato_reset_tipo_ajax_")
     * @Method({"DELETE"})
     * @Template("")
     */
    public function resetcontenedorMercanciaFormatoCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $pk = $request->get('pk', -1);
        $numero = $request->get('numero',NULL);
        $em = $this->getDoctrine()->getManager();
        $str_tipo = $request->get('str_tipo','');
        
        $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic', 'aplicableA' => 'Formato'));
        $cm = null;
        $datos = array();
        if($tipo){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo->getId(), 'numero' => $numero));
            if($formato){
                if(is_numeric($pk) && $pk >= 0){
                    $cm = $this->getRepositorio()->find($pk);
                    if($cm){
                        $em->remove($cm);
                        $em->flush();
                    }
                    $success = array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Mercancía "'.$cm->getMercancia()->__toString().'" removida del Formato','tipo' => 'success')));
                }
                else{
                    $success = array('msgs' => array('Contenedor Mercancía' => array('msg' => 'Datos No Válidos!!','tipo' => 'danger')));
                }
                $datos = array(
                    'success'   =>  $success,
                    'datos'     =>  array(
                            'pesoBruto'     =>  $formato->getTotalPesoBruto(),
                            'pesoNeto'      =>  $formato->getTotalPesoNeto(),
                            'volumen'       =>  $formato->getTotalVolumen(),
                            'volumenOtro'   =>  $formato->getTotalVolumenOtro(),
                        ),
                );
                return JsonResponse::create($datos);
            }else{
                $datos['errors']['Contenedor Mercancias'] = 'Datos no válidos';
                return JsonResponse::create($datos);
            }
        }
        return array(
            'fila'         =>  $filas,
            'formato'      =>  $formato,
            'cm'           =>  $cm,
        );
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
     * @return ContenedorMercanciaFormatoRepository  ContenedorMercanciaFormatoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato');
    }
}
