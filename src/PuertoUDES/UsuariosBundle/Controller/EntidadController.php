<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\UsuariosBundle\Entity\Entidad;
use Symfony\Component\Form\FormBuilder;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\UsuariosBundle\Repository\EntidadRepository;
use PuertoUDES\UsuariosBundle\Form\EntidadType;

/**
 * Entidad controller.
 *
 * @Route("/Entidad")
 */
class EntidadController extends Controller
{

    /**
     * Lists all Entidad entities.
     *
     * @Route("/", name="entidad_")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Entidades';
        $entity = 'Entidad';
        $bundle = 'Usuarios';
        $route = 'entidad_';
        $limit = 10;
        $utils = $this->getUtils();
        if(is_null($config)){
            $qb = $this->getRepositorio()->getAll();
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
            $str_query = $this->getQueryFilter($data, $head['fil'][0]['col']);
            if(!empty($str_query))
                $qb->andWhere($str_query);
        }
//        $qb = $qb->getQuery();
        $paginacion = $utils->getPaginacion($entity, $bundle, $limit, $route, $qb);
//        $paginacion['form_filter'] = $form;
        $botones = array(
            array(
                'url'   => $this->generateUrl('entidad__new'),
                'type'  => 'primary',
                'label' => '<span class="glyphicon glyphicon-plus" ></span> Agregar',
            ),
        );
        $datos = array(
            'paginas'       =>  $paginacion['pag'],
            'title'         =>  $title,
            'head'          =>  $head,
            'botones'       =>  $botones,
        );
        if($request->isXmlHttpRequest() || $request->get('ajax',false)){
            return $this->render('FormatEasyCommonBundle:Index:_menu.html.twig', $datos);
        }
        return $datos;
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Remitentes/", name="entidad__remitentes")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexRemitentesAction(Request $request)
    {   
        return $this->indexAction($request, array(
            'title'     =>  'Remitentes',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__remitentes',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getRemitentes(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Destinatarios/", name="entidad__destinatarios")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexDestinatariosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Destinatarios',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__destinatarios',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getDestinatarios(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Notificados/", name="entidad__notificados")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexNotificadosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Notificados',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__notificados',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getNotificados(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Consignatarios/", name="entidad__consignatarios")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexConsignatariosAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Consignatarios',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__consignatarios',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getConsignatarios(null, false, true),
        ));
    }
    /**
     * Lists all Entidad Remitente entities.
     *
     * @Route("/Transportistas/", name="entidad__transportistas")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexTransportistasAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Transportistas',
            'entity'    =>  'Entidad',
            'bundle'    =>  'Usuarios',
            'route'     =>  'entidad__transportistas',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getTransportistas(null, false, true),
        ));
    }
    /**
     * Creates a new Entidad entity.
     *
     * @Route("/", name="entidad__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Entidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Entidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/new", name="entidad__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Entidad();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Entidad entity.
     *
     * @Route("/{id}", name="entidad__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Entidad entity.
     *
     * @Route("/{id}/edit", name="entidad__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
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
    * Creates a form to edit a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entidad entity.
     *
     * @Route("/{id}", name="entidad__update")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Entidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Entidad entity.
     *
     * @Route("/{id}", name="entidad__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entidad_'));
    }

    /**
     * Creates a form to delete a Entidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entidad__delete', array('id' => $id)))
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESUsuariosBundle:Entidad');
    }
    
    public function getHeadFiltro(FormBuilder $form, $route){
        $head['fil'] = array(
            array(
                'col'=>array(
                    array(
                        'dato'    =>   'Doc Id',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Descripcion',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Direccion',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Telefono',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Certificado Idoneidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Tipo Doc Id',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'entidad__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'entidad__delete',
                                'data_url'=> array('id'),
                                'type'  => 'danger',
                                'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                            ),
                        )
                    ),
                )
            ),
        );
        foreach($head['fil'][0]['col'] as $col){
            if(!isset($col['acciones'])){
                $form->add(str_replace(' ', '', $col['dato']), 'text', 
                    array(
                        'required' => false, 
                        'label' =>false,
                        'attr' => array('class' => 'form-control'),
                    )
                );
            }
        }
        $form->add('Buscar', 'submit',
            array(
                    'label'=> ' Buscar',
                    'attr' => array('class' => 'btn btn-success btn-lg glyphicon glyphicon-search')
                )
            )
            ->setAction($this->generateUrl($route));
        $form = $form->getForm();
        $head['filtros'] = $form;
        return $head;
    }
    
    public function getQueryFilter($data, array $columnas = array()) {
        $l = count($columnas)-1;
        $i = 0;
        $str_query = '';
        foreach($columnas as $col){
            $col_name = str_replace(array(' ','-'), '', $col['dato']);
            if (array_key_exists($col_name, $data)){
                $data_bd = strtolower(substr($col['dato'], 0, 1)).substr($col['dato'], 1);
                $data_bd = str_replace(' ','',$data_bd);
                $data_bd = str_replace('-','',$data_bd);
                $data[$col_name] = trim($data[$col_name]);
                if (strlen($data[$col_name])>0){
                    $letra = 'a.';
                    if($data_bd === 'certificadoIdoneidad'){
                        $letra = "e.";
                    }
                    if($i > 0 && $i < $l)
                        $str_query .= ' AND ';
                    $col_datos = explode(',', $data[$col_name]);
                    $count = count($col_datos)-1;
                    if($count >= 1){
//                        $str_query .= '(';
                        foreach($col_datos as $j => $cd){
                            $str_operacion = "LIKE";
                            if($j > 0 && $j <= $count)
                                $str_query .= ' AND ';
                            $query = $letra.$data_bd." ?operacion? '%".$cd."%'";
//                            if(is_numeric($data[$col_name])){
//                                $str_operacion = '=';
//                                $str_query = str_replace(array("'","%"),'',$str_query);
//                            }
                            $str_query .= str_replace('?operacion?', $str_operacion, $query);
                        }
//                        $str_query .= ')';
                    }else{
                        $str_operacion = "LIKE";
                        $query = $letra.$data_bd." ?operacion? '%".$data[$col_name]."%'";
//                        if(is_numeric($data[$col_name])){
//                            $str_operacion = '=';
//                            $str_query = str_replace(array("'","%"),'',$str_query);
//                        }
                        $str_query .= str_replace('?operacion?', $str_operacion, $query);
                    }
                    $i++;
                }
            }
        }
        return $str_query;
    }
}
