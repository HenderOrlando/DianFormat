<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\Formato;
use PuertoUDES\FormatosBundle\Form\FormatoType;

/**
 * Formato controller.
 *
 * @Route("/Formato")
 */
class FormatoController extends Controller
{

    /**
     * Lists all Formato entities.
     *
     * @Route("/", name="formato_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Formatos';
        $entity = 'Formato';
        $bundle = 'Formato';
        $route = 'formato_';
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
        
        $head = $this->getHeadFiltro($utils->getFormFilter(array(), $route, true), $route, is_null($config));
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
        if(!is_null($config) && isset($config['abrevia']))
            $url_ = $this->generateUrl('formato__new_', array('abrevia' => $config['abrevia']));
        else
            $url_ = $this->generateUrl('formato__new');
        $botones = array(
            array(
                'url'   => $url_,
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
     * Lists all Formato entities.
     *
     * @Route("/CPIC/", name="formato__cpic")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function cpicAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Carta de Porte Internacional por Carretera',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'cpic',
            'route'     =>  'formato__cpic',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getCpic(null, false, true),
        ));
    }
    /**
     * Lists all Formato entities.
     *
     * @Route("/MCI/", name="formato__mci")
     * @Method("GET")
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function mciAction(Request $request)
    {
        return $this->indexAction($request, array(
            'title'     =>  'Manifiesto de Carga Internacional',
            'entity'    =>  'Formato',
            'bundle'    =>  'Common',
            'abrevia'   =>  'mci',
            'route'     =>  'formato__mci',
            'limit'     =>  5,
            'qb'        =>  $this->getRepositorio()->getMci(null, false, true),
        ));
    }
    
    /**
     * Creates a new Formato entity.
     *
     * @Route("/{abrevia}", name="formato__create_")
     * @Route("/", name="formato__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Formato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Formato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/nuevo/{abrevia}", name="formato__new_")
     * @Route("/nuevo/", name="formato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($abrevia = null)
    {
        $entity = new Formato();
        $form   = $this->createCreateForm($entity);
        if(!is_null($abrevia)){
            return $this->render('PuertoUDESFormatosBundle:Formato:'.$abrevia.'.html.twig', array());
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Formato entity.
     *
     * @Route("/{id}", name="formato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Formato entity.
     *
     * @Route("/{id}/edit", name="formato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
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
    * Creates a form to edit a Formato entity.
    *
    * @param Formato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Formato $entity)
    {
        $form = $this->createForm(new FormatoType(), $entity, array(
            'action' => $this->generateUrl('formato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Formato entity.
     *
     * @Route("/{id}", name="formato__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Formato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Formato entity.
     *
     * @Route("/{id}", name="formato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Formato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formato_'));
    }

    /**
     * Creates a form to delete a Formato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formato__delete', array('id' => $id)))
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
     * @return FormatoRepository  FormatoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:Formato');
    }
    
    public function getHeadFiltro($form, $route, $tipo = true){
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
                )
            ),
        );
        if(is_bool($tipo) && $tipo){
            $filas[0]['col'][] = array(
                'dato'    =>   'canonical',
                'label'    =>   'Tipo de Formato',
                'join'    =>   'tipo',
                'class' =>  'text-center',
            );
        }
        $filas[0]['col'][] = array(
            'dato'    =>   'Acciones',
            'class' =>  'text-center',
            'acciones'=>    array(
                array(
                    'url'   => 'formato__edit',
                    'data_url'=> array('id'),
                    'type'  => 'default',
                    'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                ),
                array(
                    'url'   => 'formato__delete',
                    'data_url'=> array('id'),
                    'type'  => 'danger',
                    'label' => '<span class="glyphicon glyphicon-trash" ></span> Borrar',
                ),
            )
        );
        return $this->getUtils()->getHeadFiltro($filas, $form, $route);
    }
}
