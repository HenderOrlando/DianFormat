<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\CommonBundle\Entity\Contenedor;
use PuertoUDES\CommonBundle\Form\ContenedorType;

/**
 * Contenedor controller.
 *
 * @Route("/Contenedor")
 */
class ContenedorController extends Controller
{

    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Guardar/{tipo}/{numero_mci}/", name="contenedor_save_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveAjaxAction(Request $request){
        $capacidad = $request->get('capacidad',NULL);
        $numeroContenedor = $request->get('numero',NULL);
        $numero = $request->get('numero_mci',NULL);
        $em = $this->getDoctrine()->getManager();
        $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero));
        $datos = array(
            'errors' => array(),
        );
        if($formato && is_numeric($capacidad)){
            $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower('MCI')));
            if($tipo->getId() === $formato->getTipo()->getId()){
                $contenedor = $this->getRepositorio()->findOneBy(array('numero' => $numeroContenedor));
                if(!$contenedor){
                    $contenedor = new Contenedor();
                    $contenedor
                            ->setNumero($numeroContenedor)
                            ->setCapacidad($capacidad)
                            ->setSigla($numeroContenedor);
                    $em->persist($contenedor);
                    $em->flush();
                }
                $cmfs = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')
                    ->createQueryBuilder('cmf')
                    ->join('cmf.formato', 'f')
                    ->andWhere('f.padre = '.$formato->getId())
                    ->getQuery()->execute();
                if(empty($cmfs)){
                    $cmf = new \PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato();
                    $cmf
                        ->setContenedor($contenedor)
                        ->setFormato($formato);
                    $em->persist($cmf);
                    $formato->addContenedoresMercancia($cmf);
                    $contenedor->addMercanciasFormato($cmf);
                    $em->persist($formato);
                }
                foreach($cmfs as $cmf){
                    $cmf->setContenedor($contenedor);
                    $em->persist($cmf);
                }
                $em->flush();
                $datos['id'] = $contenedor->getId();
                $datos['valores'] = $contenedor->json(false);
                $datos['success']['msgs']['Contenedor'] = array(
                    'msg' => 'Contenedor de número <strong>"'.$contenedor->getNumero().'"</strong> fué agregado',
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
     * Lists all Contenedor entities.
     *
     * @Route("/", name="contenedor_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Contenedores';
        $entity = 'Contenedor';
        $bundle = 'Common';
        $route = 'contenedor_';
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
                'url'   => $this->generateUrl('contenedor__new'),
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
     * Creates a new Contenedor entity.
     *
     * @Route("/", name="contenedor__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Contenedor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contenedor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenedor__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Contenedor entity.
    *
    * @param Contenedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Contenedor $entity)
    {
        $form = $this->createForm(new ContenedorType(), $entity, array(
            'action' => $this->generateUrl('contenedor__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contenedor entity.
     *
     * @Route("/new", name="contenedor__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contenedor();
        $form   = $this->createCreateForm($entity);

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nuevo Contenedor',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            //$title = empty($entity->getNumero())?$entity->getSigla():$entity->getNumero();
			$title = 'Contenedor';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Contenedor:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Contenedor entity.
     *
     * @Route("/{id}/edit", name="contenedor__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
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
            //$title = empty($entity->getNumero())?$entity->getSigla():$entity->getNumero();
			$title = 'Contenedor';
            return JsonResponse::create(array(
                'title' => $title,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Contenedor entity.
    *
    * @param Contenedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contenedor $entity)
    {
        $form = $this->createForm(new ContenedorType(), $entity, array(
            'action' => $this->generateUrl('contenedor__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Contenedor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contenedor__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contenedor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenedor_'));
    }

    /**
     * Creates a form to delete a Contenedor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contenedor__delete', array('id' => $id)))
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
     * @return ContenedorRepository  ContenedorRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Contenedor');
    }
    
    public function getHeadFiltro($form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'    =>   'Numero',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Capacidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Sigla',
                        'label'    =>   'Sigla/Numero',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'contenedor__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'contenedor__delete',
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
