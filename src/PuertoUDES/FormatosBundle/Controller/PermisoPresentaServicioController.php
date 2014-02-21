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
use PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio;
use PuertoUDES\FormatosBundle\Form\PermisoPresentaServicioType;

/**
 * PermisoPresentaServicio controller.
 *
 * @Route("/PermisoPresentaServicio")
 */
class PermisoPresentaServicioController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_permisos_presenta_servicios_")
     * @Template("PuertoUDESFormatosBundle:Formato:_addEntidadCpicAjax.html.twig")
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $name = $request->get('name','');
        $entities = $this->getRepositorio()->findAll();
        $propertyPath = new PropertyAccessor();
        foreach($entities as $pps){
            $value = $propertyPath->getValue($pps,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $pps->getTokens(),
                'datos' =>  $pps->json(false)
            );
        }
        return JsonResponse::create($list);
    }
    
    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Transportista/Guardar/{tipo}/{numero}/", name="permisos_save_transportista_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function savePermisosTransportistaAjaxAction(Request $request){
        $nombre = $request->get('name',NULL);
        $valor = $request->get('value',NULL);
        $llave = $request->get('pk',NULL);
        $permisos = preg_split('/\s?,\s?/', str_replace(' ', '', $valor));
        $em = $em = $this->getDoctrine()->getManager();
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero));
        $entidad = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->find($llave);
        $datos = array(
            'errors' => array(),
        );
//        $this->getUtils()->dump($permisos);
        if($formato && $entidad){
            $entidad = $entidad->getEntidad();
            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($tipo)));
            if($tipo->getId() === $formato->getTipo()->getId()){
                $mod = false;
                $entidad->getPermisosPresentaServicios()->clear();
                foreach($permisos as $permiso){
                    if(empty($permiso))
                        continue;
                    $p = $this->getRepositorio()->like(array('nombre' => $permiso));
                    if(!$p){
                        $p = new PermisoPresentaServicio();
                        $p->setNombre($permiso);
                    }
                    if(!$entidad->hasPermisosPresentaServicio($p)){
                        $p->addEntidad($entidad);
                        $em->persist($p);
                        $entidad->addPermisosPresentaServicio($p);
                        $mod = true;
                    }
                }
                if($mod){
                    $em->persist($entidad);
                }
                $em->flush();
                $datos['id'] = $entidad->getId();
                $datos['value'] = $entidad->getStringPermisosPresentaServicio();
                $datos['msgs'][] = array('msg' => 'Entidad: Los permisos fueron actualizados.', 'tipo' => 'success');
            }else{
                $datos['errors']['Entidad'] = 'Formato o Entidad no válidas.';
            }
        }else{
            $datos['errors']['Entidad'] = 'Formato o Entidad no válidas.';
        }
        return \Symfony\Component\HttpFoundation\JsonResponse::create($datos);
    }

    /**
     * Lists all PermisoPresentaServicio entities.
     *
     * @Route("/", name="permisoPresentaServicio_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Permisos para Presentar Servicio';
        $entity = 'PermisoPresentaServicio';
        $bundle = 'PermisoPresentaServicio';
        $route = 'permisoPresentaServicio_';
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
                'url'   => $this->generateUrl('permisoPresentaServicio__new'),
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
     * Creates a new PermisoPresentaServicio entity.
     *
     * @Route("/", name="permisoPresentaServicio__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:PermisoPresentaServicio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PermisoPresentaServicio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('permisoPresentaServicio__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PermisoPresentaServicio entity.
    *
    * @param PermisoPresentaServicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PermisoPresentaServicio $entity)
    {
        $form = $this->createForm(new PermisoPresentaServicioType(), $entity, array(
            'action' => $this->generateUrl('permisoPresentaServicio__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PermisoPresentaServicio entity.
     *
     * @Route("/new", name="permisoPresentaServicio__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PermisoPresentaServicio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PermisoPresentaServicio entity.
     *
     * @Route("/{id}/edit", name="permisoPresentaServicio__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
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
    * Creates a form to edit a PermisoPresentaServicio entity.
    *
    * @param PermisoPresentaServicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PermisoPresentaServicio $entity)
    {
        $form = $this->createForm(new PermisoPresentaServicioType(), $entity, array(
            'action' => $this->generateUrl('permisoPresentaServicio__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:PermisoPresentaServicio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('permisoPresentaServicio__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('permisoPresentaServicio_'));
    }

    /**
     * Creates a form to delete a PermisoPresentaServicio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('permisoPresentaServicio__delete', array('id' => $id)))
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
     * @return PermisoPresentaServicioRepository  PermisoPresentaServicioRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio');
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
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'permisoPresentaServicio__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'permisoPresentaServicio__delete',
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
