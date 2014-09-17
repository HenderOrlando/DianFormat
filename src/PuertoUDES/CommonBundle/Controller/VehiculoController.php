<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\CommonBundle\Entity\Vehiculo;
use PuertoUDES\CommonBundle\Form\VehiculoType;

/**
 * Vehiculo controller.
 *
 * @Route("/Vehiculo")
 */
class VehiculoController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_vehiculos_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = $this->getRepositorio()->findAll();
        $name = $request->get('name','');
        $propertyPath = new PropertyAccessor();
        foreach($entities as $vehiculo){
            $value = $propertyPath->getValue($vehiculo,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $vehiculo->getTokens(true),
                'datos' =>  $vehiculo->json(false)
            );
        }
        if($name === 'pais')
            return JsonResponse::create($this->listTypeaheadPaises($list));
        return JsonResponse::create($list);
    }
    public function listTypeaheadPaises($list = array()){
        $entities = $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Pais')->findAll();
        foreach($entities as $pais){
            $list[] = array(
                'value' =>  $pais->getNombre(),
                'tokens'=>  $pais->getTokens(false),
                'datos' =>  $pais->json(false)
            );
        }
        return $list;
    }
    
    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Guardar/{tipo}/{numero}/", name="vehiculo_save_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveAjaxAction(Request $request){
        $marca = $request->get('marca',NULL);
        $aniof = $request->get('anioFabrica',NULL);
        $placa = $request->get('placa',NULL);
        $p  = $request->get('pais',NULL);
        $numsc = strtoupper($request->get('numSerieChasis',''));
        $certh = strtoupper($request->get('certificadoHabilitacion',''));
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $em = $this->getDoctrine()->getManager();
        $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero));
        $datos = array(
            'errors' => array(),
        );
        if($formato && is_string($aniof) && strlen($aniof) == 4){
            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($tipo)));
            if($tipo->getId() === $formato->getTipo()->getId()){
                $vehiculo = $this->getRepositorio()->findOneBy(array('placa' => $placa));
                if(!$vehiculo){
                    $vehiculo = new Vehiculo();
                    $vehiculo
                            ->setCertificadoHabilitacion($certh)
                            ->setNumeroSerieChasis($numsc)
                            ->setAnioFabrica($aniof)
                            ->setMarca($marca)
                            ->setPlaca($placa);
                    $pais = $em->getRepository('PuertoUDESCommonBundle:Pais')
                            ->createQueryBuilder('p')
                            ->andWhere('p.canonical LIKE \'%'.$p.'%\' OR p.nombre LIKE \'%'.$p.'%\'')
                            ->getQuery()->getOneOrNullResult();
                    if(!$pais){
                        $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                        $pais->setNombre($p)
                            ->setNacionalidad($p);
                        $em->persist($pais);
                    }
                    $vehiculo->setPais($pais);
                    $em->persist($vehiculo);
                }
                $fc = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')
                        ->createQueryBuilder('fc')
                        ->innerJoin('fc.vehiculo','v')
                        ->andWhere('fc.formato = '.$formato->getId())
                        ->andWhere('v.placa LIKE \'%'.$placa.'%\'')
                        ->getQuery()->execute();
                if(!$fc){
                    $fc = new \PuertoUDES\FormatosBundle\Entity\FormatoConductor();
                    $fc->setFormato($formato);
                    $fc->setVehiculo($vehiculo);
                    $em->persist($fc);
                    $formato->addConductor($fc);
                    $vehiculo->addFormato($fc);
                    $em->persist($formato);
                    $em->persist($vehiculo);
                }elseif($fc[0]->getVehiculo()->getId() != $vehiculo->getId()){
                    $vh = $fc[0]->getVehiculo();
                    foreach($fc as $f){
                        $vh->removeFormato($f);
                        $em->persist($vh);
                        $fc->setVehiculo($vehiculo);
                        $vehiculo->addFormato($fc);
                        $em->persist($fc);
                    }
                    $em->persist($vehiculo);
                }else{
                    if($vehiculo->getCertificadoHabilitacion() != $certh){
                        $vehiculo->setCertificadoHabilitacion($certh);
                    }
                    if($vehiculo->getNumeroSerieChasis() != $numsc){
                        $vehiculo->setNumeroSerieChasis($numsc);
                    }
                    $em->persist($vehiculo);
                }
                $em->flush();
                $datos['id'] = $vehiculo->getId();
                $datos['valores'] = $vehiculo->json(false);
                $datos['success']['msgs']['Vehiculo'] = array(
                    'msg' => 'Vehiculo de placa <strong>"'.$vehiculo->getPlaca().'"</strong> fué agregado',
                    'tipo' => 'success'
                );
            }else{
                $datos['errors']['Vehiculo'] = 'Datos inválidos.';
            }
        }else{
            if(!is_string($aniof) || strlen($aniof) != 4){
                $datos['errors']['Vehiculo'] = 'El año de fabricación del vehiculo debe ser de 4 dígitos.';
            }else
                $datos['errors']['Vehiculo'] = 'El Formato "'.$tipo.'" no existe.';
        }
        return JsonResponse::create($datos);
    }

    /**
     * Lists all Vehiculo entities.
     *
     * @Route("/", name="vehiculo_")
     * @Method({"GET","PATCH"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Vehiculos';
        $entity = 'Vehiculo';
        $bundle = 'Common';
        $route = 'vehiculo_';
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
                'url'   => $this->generateUrl('vehiculo__new'),
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
     * Creates a new Vehiculo entity.
     *
     * @Route("/", name="vehiculo__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Vehiculo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vehiculo__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Vehiculo entity.
    *
    * @param Vehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Vehiculo $entity)
    {
        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vehiculo entity.
     *
     * @Route("/new", name="vehiculo__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vehiculo();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nuevo Vehiculo',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            //$title = empty($entity->getPlaca())?$entity->getMarca():$entity->getPlaca();
			$title = 'Vehiculo';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Vehiculo:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/{id}/edit", name="vehiculo__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
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
            //$title = empty($entity->getPlaca())?$entity->getMarca():$entity->getPlaca();
			$title = 'Vehiculo';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Vehiculo entity.
    *
    * @param Vehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vehiculo $entity)
    {
        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Vehiculo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vehiculo__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vehiculo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vehiculo_'));
    }

    /**
     * Creates a form to delete a Vehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculo__delete', array('id' => $id)))
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
     * @return VehiculoRepository  VehiculoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Vehiculo');
    }
    
    public function getHeadFiltro($form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'    =>   'Placa',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Marca',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Anio Fabrica',
                        'label'    =>   'Año de Fábrica',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Num Serie Chasis',
                        'label'    =>   'Numero de Serie del Chasis',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Certifica Habilita',
                        'label'    =>   'Certificado de Habilitación',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'canonical',
                        'label'    =>   'País',
                        'join'    =>   'pais',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'vehiculo__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'vehiculo__delete',
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
