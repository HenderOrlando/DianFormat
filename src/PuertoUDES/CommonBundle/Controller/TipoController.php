<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use PuertoUDES\CommonBundle\Entity\Tipo;
use PuertoUDES\CommonBundle\Form\TipoType;

/**
 * Tipo controller.
 *
 * @Route("/Tipo")
 */
class TipoController extends Controller
{
/**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_tipos_")
     * @Route("/{rol}/Lista/para/{name}/", name="list_typeahead_tipos")
     * @Template("PuertoUDESFormatosBundle:Formato:_addEntidadCpicAjax.html.twig")
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = array();
        $name = $request->get('name','');
        $rol = $request->get('rol','');
        switch(strtolower($rol)){
            case 'usuario':
                $entities = $this->getRepositorio()->getTipoUsuario();
                break;
            case 'declarante':
                $entities = $this->getRepositorio()->getByAplicableA('declarante');
                break;
            case 'declaracion':
                $entities = $this->getRepositorio()->getByAplicableA('declaracion');
                break;
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
    
    /**
     * Lists all Tipo entities.
     *
     * @Route("/", name="tipo_")
     * @Method({"GET","PATCH"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Tipos de Formatos';
        $entity = 'Tipo';
        $bundle = 'Common';
        $route = 'tipo_';
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
                'url'   => $this->generateUrl('tipo__new'),
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
            return $this->render('PuertoUDESCommonBundle:Plantilla:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Creates a new Tipo entity.
     *
     * @Route("/licencias-de-conductores/", name="tipo__licenciasConductor")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function licenciasConductorAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Clases de Licencias de Conducción',
            'entity'    =>  'Tipo',
            'bundle'    =>  'Common',
            'route'     =>  'tipo__licenciasConductor',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getClasesLicenciasConductor(null, false, true),
        ));
    }
    /**
     * Creates a new Tipo entity.
     *
     * @Route("/formatos/", name="tipo__tiposFormatos")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function tiposFormatosAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Tipos de Formatos',
            'entity'    =>  'Tipo',
            'bundle'    =>  'Common',
            'route'     =>  'tipo__tiposFormatos',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getTiposFormato(null, false, true),
        ));
    }
    /**
     * Creates a new Tipo entity.
     *
     * @Route("/naturalezas-de-carga/", name="tipo__naturalezasCarga")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function naturalezasCargaAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Naturalezas de la Carga',
            'entity'    =>  'Tipo',
            'bundle'    =>  'Common',
            'route'     =>  'tipo__naturalezasCarga',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getNaturalezaCarga(null, false, true),
        ));
    }
    /**
     * Creates a new Tipo entity.
     *
     * @Route("/niveles-aduanas/", name="tipo__nivelesAduana")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function nivelesAduanaAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Niveles de Aduanas',
            'entity'    =>  'Tipo',
            'bundle'    =>  'Common',
            'route'     =>  'tipo__nivelesAduana',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getNivelesAduana(null, false, true),
        ));
    }
    /**
     * Creates a new Tipo entity.
     *
     * @Route("/", name="tipo__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Tipo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tipo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipo__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Tipo entity.
    *
    * @param Tipo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Tipo $entity)
    {
        $form = $this->createForm(new TipoType(), $entity, array(
            'action' => $this->generateUrl('tipo__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('data-reload' => $this->generateUrl('tipo_',array(),true))));

        return $form;
    }

    /**
     * Displays a form to create a new Tipo entity.
     *
     * @Route("/new", name="tipo__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tipo();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nuevo Tipo',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Tipo entity.
     *
     * @Route("/{id}", name="tipo__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Tipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            //$title = empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre();
			$title = '';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Tipo:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Tipo entity.
     *
     * @Route("/{id}/edit", name="tipo__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Tipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipo entity.');
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
            //$title = empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre();
			$title = 'Tipo';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Tipo entity.
    *
    * @param Tipo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tipo $entity)
    {
        $form = $this->createForm(new TipoType(), $entity, array(
            'action' => $this->generateUrl('tipo__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('data-reload' => $this->generateUrl('tipo_',array(),true))));

        return $form;
    }
    /**
     * Edits an existing Tipo entity.
     *
     * @Route("/{id}", name="tipo__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Tipo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Tipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipo__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Tipo entity.
     *
     * @Route("/{id}", name="tipo__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Tipo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tipo entity.');
            }

            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return JsonResponse::create(array(
                    'title' => $entity->getNombre(),
                    'body'  => 'El tipo "'.$entity->getNombre().'" fué eliminado con éxito.',
                ));
            }
        }

        return $this->redirect($this->generateUrl('tipo_'));
    }

    /**
     * Creates a form to delete a Tipo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('data-reload' => $this->generateUrl('tipo_',array(),true))))
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
     * @return TipoRepository  TipoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Tipo');
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
                                'url'   => 'tipo__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'tipo__delete',
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
