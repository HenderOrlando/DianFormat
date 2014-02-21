<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\CommonBundle\Entity\Incoterm;
use PuertoUDES\CommonBundle\Form\IncotermType;

/**
 * Incoterm controller.
 *
 * @Route("/Incoterm")
 */
class IncotermController extends Controller
{
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_incoterms_")
     * @Route("/{tipo}/Lista/para/{name}/", name="list_typeahead_incoterms")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = array();
        $name = $request->get('name','');
        $entities = $this->getRepositorio()->findAll();
        $propertyPath = new PropertyAccessor();
        foreach($entities as $incoterm){
            $value = $propertyPath->getValue($incoterm,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $incoterm->getTokens(),
                'datos' =>  $incoterm->json(false)
            );
        }
        return JsonResponse::create($list);
    }

    /**
     * Lists all Incoterm entities.
     *
     * @Route("/", name="incoterm_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Incotermes';
        $entity = 'Incoterm';
        $bundle = 'Common';
        $route = 'incoterm_';
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
                'url'   => $this->generateUrl('incoterm__new'),
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
     * Creates a new Incoterm entity.
     *
     * @Route("/", name="incoterm__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Incoterm:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Incoterm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('incoterm__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Incoterm entity.
    *
    * @param Incoterm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Incoterm $entity)
    {
        $form = $this->createForm(new IncotermType(), $entity, array(
            'action' => $this->generateUrl('incoterm__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Incoterm entity.
     *
     * @Route("/new", name="incoterm__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Incoterm();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => 'Agregar Nueva Mercancía',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESCommonBundle:Incoterm:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Incoterm entity.
     *
     * @Route("/{id}/edit", name="incoterm__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
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
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Incoterm entity.
    *
    * @param Incoterm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Incoterm $entity)
    {
        $form = $this->createForm(new IncotermType(), $entity, array(
            'action' => $this->generateUrl('incoterm__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Incoterm:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('incoterm__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Incoterm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('incoterm_'));
    }

    /**
     * Creates a form to delete a Incoterm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('incoterm__delete', array('id' => $id)))
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Incoterm');
    }
    
    public function getHeadFiltro($form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'  =>  'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'  =>  'Descripcion',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'  =>  'Sigla',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'  =>  'categoria',
                        'label' =>  'Categoría',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'  =>  'anio',
                        'label' =>  'Año',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'incoterm__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'incoterm__delete',
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
