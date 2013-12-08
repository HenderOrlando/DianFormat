<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Controller\IndexController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\FormatosBundle\Entity\Gasto;
use PuertoUDES\FormatosBundle\Form\GastoType;

/**
 * Gasto controller.
 *
 * @Route("/Gasto")
 */
class GastoController extends Controller
{

    /**
     * Lists all Gasto entities.
     *
     * @Route("/", name="gasto_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Gasto entity.
     *
     * @Route("/", name="gasto__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Gasto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Gasto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gasto__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Gasto entity.
    *
    * @param Gasto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Gasto $entity)
    {
        $form = $this->createForm(new GastoType(), $entity, array(
            'action' => $this->generateUrl('gasto__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Gasto entity.
     *
     * @Route("/new", name="gasto__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Gasto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Gasto entity.
     *
     * @Route("/{id}", name="gasto__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Gasto entity.
     *
     * @Route("/{id}/edit", name="gasto__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
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
    * Creates a form to edit a Gasto entity.
    *
    * @param Gasto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Gasto $entity)
    {
        $form = $this->createForm(new GastoType(), $entity, array(
            'action' => $this->generateUrl('gasto__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Gasto entity.
     *
     * @Route("/{id}", name="gasto__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Gasto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gasto__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Gasto entity.
     *
     * @Route("/{id}", name="gasto__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gasto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gasto_'));
    }

    /**
     * Creates a form to delete a Gasto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gasto__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/{concepto}/Agregar/a/CPIC-{fila}/{numero}/", name="gasto_add_cpic_ajax")
     * @Route("/{concepto}/Agregar/a/CPIC/{numero}/", name="gasto_add_cpic_ajax")
     * @Route("/{concepto}/Agregar/a/CPIC-{fila}/{numero}/para/{rolUsuario}/", name="gasto_add_cpic_ajax_")
     * @Route("/{concepto}/Agregar/a/CPIC/{numero}/para/{rolUsuario}/", name="gasto_add_cpic_ajax_")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Gasto:_addGastoAjax.html.twig")
     */
    public function addGastosCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $numero = $request->get('numero', 0);
        $concepto = $request->get('concepto',NULL);
        $valor = $request->get('valor',NULL);
        $moneda = $request->get('moneda',NULL);
        $rolUsuario = $request->get('rolUsuario',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic', 'aplicableA' => 'Formato'));
        $gasto = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($concepto && !is_null($valor)){
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
                    $error = false;
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
                        $q = $this->getRepositorio()->createQueryBuilder('g')
                            ->innerJoin('g.concepto', 't')
                            ->andWhere("g.formato='".$formato->getId()."'")
                            ->andWhere("t.canonical LIKE '%".$concepto."%' OR t.nombre LIKE '%".$concepto."%' OR t.abreviacion LIKE '%".$concepto."%'")
                            ->andWhere("t.id = ".$tipoGasto->getId());
                        if($rolUsuario){
                            $q->andWhere('g.rolUsuario='.$rolUsuario->getId());
                        }
                        $gasto = $q->getQuery()->getOneOrNullResult();
                        if(!$gasto){
                            $gasto = new Gasto();
                            $gasto
                                    ->setValor($valor)
                                    ->setFormato($formato)
                                    ->setConcepto($tipoGasto);
                            $em->persist($gasto);
                        }
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
                        $em->persist($tipoGasto);
                        $em->persist($formato);
                        $em->flush();
                        $datos['success']['msgs']['Gasto'] = array(
                            'msg' => 'Agregado "'.$gasto->getConcepto().'" ('.$gasto->getValor().$gasto->getMoneda()->getAbreviacion().')',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $gasto->getId();
                        $datos['datos'] = array_merge($gasto->json(false),array(
                                'gastoRemitente' => $formato->getGastoTotalRemitente(),
                                'gastoDestinatario' => $formato->getGastoTotalDestinatario(),
                            ));
                    }
                    return JsonResponse::create($datos);
                }else{
                    $datos['errors']['Formato'] = 'Datos incompletos. No definidos el Concepto ni el Valor.';
                }
            }else{
                $datos['errors']['Formato'] = 'Datos no válidos';
            }
            return JsonResponse::create($datos);
        }
        return array(
            'fila'          =>  $filas,
            'abreviacion'   =>  $formato->getTipo()->getAbreviacion(),
            'numero'        =>  $formato->getNumero(),
            'gasto'         =>  $gasto,
            'rolUsuario'    =>  $rolUsuario,
            'tipo'          =>  $tipoGasto,
        );
    }
    
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Reset/en/{abreviacion}-{fila}/{numero}/", name="gasto_add_cpic_ajax_reset_")
     * @Route("/Reset/en/{abreviacion}/{numero}/", name="gasto_add_cpic_ajax_reset")
     * @Method({"DELETE"})
     * @Template()
     */
    public function resetAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
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
            'abreviacion'   =>  $abreviacion,
        );
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato && !is_null($pk)){
                $obj = $em->getRepository('PuertoUDES'.$bundle.'Bundle:'.$entity)->find($pk);
                if($obj){
                    $em->remove($obj);
                    $em->flush();
                    $datos['datos'] = array(
                        'gastoRemitente' => $formato->getGastoTotalRemitente(),
                        'gastoDestinatario' => $formato->getGastoTotalDestinatario(),
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
     * @return DatosMercanciasFormatoRepository  DatosMercanciasFormatoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:Gasto');
    }
    
    public function getHeadFiltro(FormBuilder $form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'      =>  'Formato',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Lugar',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Fecha',
                        'class' =>  'text-center',
                    ),
//                    array(
//                        'dato'    =>  'canonical',
//                        'label'   =>  'Tipo de Documento de dentidad',
//                        'join'    =>  'tipoDocId',
//                        'class' =>  'text-center',
//                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'datosMercancias__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'datosMercancias__delete',
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
