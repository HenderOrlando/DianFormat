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
use PuertoUDES\CommonBundle\Entity\Moneda;
use PuertoUDES\CommonBundle\Form\MonedaType;

/**
 * Moneda controller.
 *
 * @Route("/Moneda")
 */
class MonedaController extends Controller
{

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_monedas_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $name = $request->get('name','');
        $entities = $this->getRepositorio()->findAll();
        $propertyPath = new PropertyAccessor();
        foreach($entities as $moneda){
            $value = $propertyPath->getValue($moneda,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $moneda->getTokens(),
                'datos' =>  $moneda->json(false)
            );
        }
        return JsonResponse::create($list);
    }
    
    /**
     * Lists all Moneda entities.
     *
     * @Route("/", name="moneda_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Monedas';
        $entity = 'Moneda';
        $bundle = 'Common';
        $route = 'moneda_';
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
                'url'   => $this->generateUrl('moneda__new'),
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
     * Creates a new Moneda entity.
     *
     * @Route("/", name="moneda__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Moneda:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Moneda();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moneda__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Moneda entity.
    *
    * @param Moneda $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Moneda $entity)
    {
        $form = $this->createForm(new MonedaType(), $entity, array(
            'action' => $this->generateUrl('moneda__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Moneda entity.
     *
     * @Route("/new", name="moneda__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Moneda();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Moneda entity.
     *
     * @Route("/{id}", name="moneda__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Moneda entity.
     *
     * @Route("/{id}/edit", name="moneda__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
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
    * Creates a form to edit a Moneda entity.
    *
    * @param Moneda $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Moneda $entity)
    {
        $form = $this->createForm(new MonedaType(), $entity, array(
            'action' => $this->generateUrl('moneda__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Moneda entity.
     *
     * @Route("/{id}", name="moneda__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Moneda:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moneda__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Moneda entity.
     *
     * @Route("/{id}", name="moneda__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Moneda entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moneda_'));
    }

    /**
     * Creates a form to delete a Moneda entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moneda__delete', array('id' => $id)))
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Moneda');
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
                        'dato'    =>   'Abreviacion',
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
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'moneda__delete',
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
