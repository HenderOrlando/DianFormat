<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Lugar;
use PuertoUDES\CommonBundle\Form\LugarType;

/**
 * Lugar controller.
 *
 * @Route("/Lugar")
 */
class LugarController extends Controller
{

    /**
     * Lists all Lugar entities.
     *
     * @Route("/", name="lugar_")
     * @Method({"GET", "POST"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Lugares';
        $entity = 'Lugar';
        $bundle = 'Common';
        $route = 'lugar_';
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
            $str_query = $this->getQueryFilter($data, $head['fil'][0]['col']);
            if(!empty($str_query))
                $qb->andWhere($str_query);
        }
        
//        $qb = $qb->getQuery();
        $paginacion = $utils->getPaginacion($entity, $bundle, $limit, $route, $qb);
//        $paginacion['form_filter'] = $form;
        $botones = array(
            array(
                'url'   => $this->generateUrl('lugar__new'),
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
     * Creates a new Lugar entity.
     *
     * @Route("/", name="lugar__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Lugar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lugar();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lugar__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Lugar entity.
    *
    * @param Lugar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Lugar $entity)
    {
        $form = $this->createForm(new LugarType(), $entity, array(
            'action' => $this->generateUrl('lugar__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lugar entity.
     *
     * @Route("/new", name="lugar__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lugar();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lugar entity.
     *
     * @Route("/{id}", name="lugar__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lugar entity.
     *
     * @Route("/{id}/edit", name="lugar__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
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
    * Creates a form to edit a Lugar entity.
    *
    * @param Lugar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lugar $entity)
    {
        $form = $this->createForm(new LugarType(), $entity, array(
            'action' => $this->generateUrl('lugar__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Lugar entity.
     *
     * @Route("/{id}", name="lugar__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Lugar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lugar__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lugar entity.
     *
     * @Route("/{id}", name="lugar__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lugar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lugar_'));
    }

    /**
     * Creates a form to delete a Lugar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lugar__delete', array('id' => $id)))
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Lugar');
    }
    
    public function getHeadFiltro($form, $route){
        $head['fil'] = array(
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
                        'dato'    =>   'Pais',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'lugar__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'lugar__delete',
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
