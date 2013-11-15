<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\UsuariosBundle\Entity\Conductor;
use PuertoUDES\UsuariosBundle\Form\ConductorType;

/**
 * Conductor controller.
 *
 * @Route("/Conductor")
 */
class ConductorController extends Controller
{

    /**
     * Lists all Conductor entities.
     *
     * @Route("/", name="conductor_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Conductores de Formatos';
        $entity = 'Conductor';
        $bundle = 'Usuarios';
        $route = 'conductor_';
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
                'url'   => $this->generateUrl('conductor__new'),
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
     * Creates a new Conductor entity.
     *
     * @Route("/", name="conductor__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Conductor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Conductor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('Conductor__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Conductor entity.
    *
    * @param Conductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Conductor $entity)
    {
        $form = $this->createForm(new ConductorType(), $entity, array(
            'action' => $this->generateUrl('Conductor__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Conductor entity.
     *
     * @Route("/new", name="conductor__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Conductor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Conductor entity.
     *
     * @Route("/{id}", name="conductor__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Conductor entity.
     *
     * @Route("/{id}/edit", name="conductor__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
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
    * Creates a form to edit a Conductor entity.
    *
    * @param Conductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Conductor $entity)
    {
        $form = $this->createForm(new ConductorType(), $entity, array(
            'action' => $this->generateUrl('Conductor__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Conductor entity.
     *
     * @Route("/{id}", name="conductor__update")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Conductor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('Conductor__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Conductor entity.
     *
     * @Route("/{id}", name="conductor__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conductor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Conductor_'));
    }

    /**
     * Creates a form to delete a Conductor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Conductor__delete', array('id' => $id)))
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
     * @return ConductorRepository  ConductorRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESUsuariosBundle:Conductor');
    }
    
    public function getHeadFiltro($form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'    =>   'Doc Id',
                        'label'    =>   'Documento de Identidad',
                        'join'    =>   'usuario',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Nombre',
                        'join'    =>   'usuario',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Descripcion',
                        'label'    =>   'Descripción',
                        'join'    =>   'usuario',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Direccion',
                        'label'    =>   'Dirección',
                        'join'    =>   'usuario',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Telefono',
                        'label'    =>   'Teléfono',
                        'join'    =>   'usuario',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Pais',
                        'label'    =>   'Nacionalidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Clase Licencia',
                        'label'    =>   'Clase de Licencia de Conducción',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Num Licencia',
                        'label'    =>   'Número de Licencia',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Num Libreta Tripulante',
                        'label'    =>   'Número de Libreta de Tripulante',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'conductor__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'conductor__delete',
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
