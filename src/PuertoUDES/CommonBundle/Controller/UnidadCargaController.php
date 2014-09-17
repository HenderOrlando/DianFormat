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
use PuertoUDES\CommonBundle\Entity\UnidadCarga;
use PuertoUDES\CommonBundle\Form\UnidadCargaType;

/**
 * UnidadCarga controller.
 *
 * @Route("/UnidadCarga")
 */
class UnidadCargaController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_unidades_carga_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = $this->getRepositorio()->findAll();
        $name = $request->get('name','');
        $propertyPath = new PropertyAccessor();
        foreach($entities as $unidadCarga){
            $value = $propertyPath->getValue($unidadCarga,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $unidadCarga->getTokens(true),
                'datos' =>  $unidadCarga->json(false)
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
                'tokens'=>  $pais->getTokens(),
                'datos' =>  $pais->json(false)
            );
        }
        return $list;
    }
    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Guardar/{tipo}/{numero}/", name="unidad_carga_save_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveAjaxAction(Request $request){
        $marca = $request->get('marca',NULL);
        $aniof = $request->get('anioFabrica',NULL);
        $placa = $request->get('placa',NULL);
        $p  = $request->get('pais',NULL);
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
                $unidadCarga = $this->getRepositorio()->findOneBy(array('placa' => $placa));
                if(!$unidadCarga){
                    $unidadCarga = new UnidadCarga();
                    $unidadCarga
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
                    $unidadCarga->setPais($pais);
                    $em->persist($unidadCarga);
                }
                $carga = $em->getRepository('PuertoUDESFormatosBundle:Carga')
                        ->createQueryBuilder('c')
//                        ->innerJoin('c.unidadCargas','uc')
                        ->andWhere('c.formato = '.$formato->getId())
//                        ->andWhere('uc.placa LIKE \'%'.$placa.'%\'')
                        ->getQuery()->execute();
                if(!$carga){
                    $carga = new \PuertoUDES\FormatosBundle\Entity\Carga();
                    $carga->setFormato($formato);
                    $carga->addUnidadCarga($unidadCarga);
                    $em->persist($carga);
                    $unidadCarga->addCarga($carga);
                    $em->persist($unidadCarga);
                    $formato->addCarga($carga);
                    $em->persist($formato);
                }elseif(!$carga[0]->hasUnidadCargas($unidadCarga)){
                    $first_uc = $carga[0]->getUnidadCarga()->first();
                    $first_uc->removeCarga($carga[0]);
                    $carga[0]->removeUnidadCarga($first_uc);
                    $carga[0]->addUnidadCarga ($unidadCarga);
                    $unidadCarga->addCarga($carga[0]);
                    $em->persist($first_uc);
                    $em->persist($carga[0]);
                    $em->persist($unidadCarga);
                }
                $em->flush();
                $datos['id'] = $unidadCarga->getId();
                $datos['valores'] = $unidadCarga->json(false);
                $datos['success']['msgs']['Unidad de Carga'] = array(
                    'msg' => 'Unidad de Carga de placa <strong>"'.$unidadCarga->getPlaca().'"</strong> fué agregado',
                    'tipo' => 'success'
                );
            }else{
                $datos['errors']['Unidad de Carga'] = 'Datos inválidos.';
            }
        }else{
            if(!is_string($aniof) || strlen($aniof) != 4){
                $datos['errors']['Unidad de Carga'] = 'El año de fabricación de la Unidad de Carga debe ser de 4 dígitos.';
            }else
                $datos['errors']['Unidad de Carga'] = 'El Formato "'.$tipo.'" no existe.';
        }
        return JsonResponse::create($datos);
    }
    
    /**
     * Lists all UnidadCarga entities.
     *
     * @Route("/", name="unidadCarga_")
     * @Method({"GET","PATCH"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Unidades de Carga';
        $entity = 'UnidadCarga';
        $bundle = 'Common';
        $route = 'unidadCarga_';
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
                'url'   => $this->generateUrl('unidadCarga__new'),
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
     * Creates a new UnidadCarga entity.
     *
     * @Route("/", name="unidadCarga__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:UnidadCarga:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UnidadCarga();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unidadCarga__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a UnidadCarga entity.
    *
    * @param UnidadCarga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(UnidadCarga $entity)
    {
        $form = $this->createForm(new UnidadCargaType(), $entity, array(
            'action' => $this->generateUrl('unidadCarga__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UnidadCarga entity.
     *
     * @Route("/new", name="unidadCarga__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UnidadCarga();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nueva Unidad de Carga',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            //$title = empty($entity->getPlaca())?$entity->getMarca():$entity->getPlaca();
			$title = 'Unidad de Carga';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:UnidadCarga:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing UnidadCarga entity.
     *
     * @Route("/{id}/edit", name="unidadCarga__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
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
			$title = 'Unidad de Carga';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a UnidadCarga entity.
    *
    * @param UnidadCarga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UnidadCarga $entity)
    {
        $form = $this->createForm(new UnidadCargaType(), $entity, array(
            'action' => $this->generateUrl('unidadCarga__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:UnidadCarga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('unidadCarga__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
            }

            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return JsonResponse::create(array(
                    'title' => $entity->getPlaca(),
                    'body'  => 'La Unidad de Carga "'.$entity->getPlaca().'" fué eliminada con éxito.',
                ));
            }
        }

        return $this->redirect($this->generateUrl('unidadCarga_'));
    }

    /**
     * Creates a form to delete a UnidadCarga entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unidadCarga__delete', array('id' => $id)))
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
     * @return UnidadCargaRepository  UnidadCargaRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:UnidadCarga');
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
                        'label'    =>   'Año de Fabrica',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'unidadCarga__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'unidadCarga__delete',
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
