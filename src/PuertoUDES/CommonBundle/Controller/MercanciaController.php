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
use PuertoUDES\CommonBundle\Entity\Mercancia;
use PuertoUDES\CommonBundle\Form\MercanciaType;

/**
 * Mercancia controller.
 *
 * @Route("/Mercancia")
 */
class MercanciaController extends Controller
{

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_mercancias_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $name = $request->get('name','');
        $entities = $this->getRepositorio()->findAll();
        $propertyPath = new PropertyAccessor();
        foreach($entities as $mercancia){
            $value = $propertyPath->getValue($mercancia,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $mercancia->getTokens(),
                'datos' =>  $mercancia->json(false)
            );
        }
        return JsonResponse::create($list);
    }
    /**
     * Lists all Mercancia entities.
     *
     * @Route("/", name="mercancia_")
     * @Method({"GET","PATCH"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Mercancias de Formatos';
        $entity = 'Mercancia';
        $bundle = 'Common';
        $route = 'mercancia_';
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
//        print_r($form->getData());
//        exit();
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
                'url'   => $this->generateUrl('mercancia__new'),
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
     * Creates a new Mercancia entity.
     *
     * @Route("/", name="mercancia__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Mercancia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mercancia();
        $form = $this->createCreateForm($entity, true);
        $form->handleRequest($request);
        $varNom = $entity->getNombre();
        if ($form->isValid() && !(empty($varNom) || is_null($varNom) || $varNom == ' ')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mercancia__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Mercancia entity.
    *
    * @param Mercancia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Mercancia $entity)
    {
        $form = $this->createForm(new MercanciaType(), $entity, array(
            'action' => $this->generateUrl('mercancia__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('data-reload' => $this->generateUrl('mercancia_',array(),true))));

        return $form;
    }

    /**
     * Displays a form to create a new Mercancia entity.
     *
     * @Route("/new", name="mercancia__new")
     * @Method({"GET"})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mercancia();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nueva Mercancía',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            //$title = empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre();
			$title = 'Mercancia';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Mercancia:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Mercancia entity.
     *
     * @Route("/{id}/edit", name="mercancia__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
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
			$title = 'Mercancia';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Mercancia entity.
    *
    * @param Mercancia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mercancia $entity)
    {
        $form = $this->createForm(new MercanciaType(), $entity, array(
            'action' => $this->generateUrl('mercancia__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('data-reload' => $this->generateUrl('mercancia_',array(),true))));

        return $form;
    }
    /**
     * Edits an existing Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Mercancia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mercancia__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mercancia entity.');
            }

            $em->remove($entity);
            $em->flush();
            if($request->isXmlHttpRequest()){
                return JsonResponse::create(array(
                    'title' => $entity->getNombre(),
                    'body'  => 'La Mercancía "'.$entity->getNombre().'" fué eliminada con éxito.',
                ));
            }
        }

        return $this->redirect($this->generateUrl('mercancia_'));
    }

    /**
     * Creates a form to delete a Mercancia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mercancia__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('data-reload' => $this->generateUrl('mercancia_',array(),true))))
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
     * @return MercanciaRepository  MercanciaRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Mercancia');
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
                                'url'   => 'mercancia__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'mercancia__delete',
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
