<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\UsuariosBundle\Entity\Entidad;
use PuertoUDES\UsuariosBundle\Entity\Usuario;
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
     * @Method({"GET"})
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
            return $this->render('FormatEasyCommonBundle:Plantilla:_menu.html.twig', $datos);
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
     * @Method({"GET", "POST"})
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
     * @Method({"GET", "POST"})
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
     * @Method({"GET", "POST"})
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
     * @Method({"GET", "POST"})
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
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/Transportista/Guardar/{tipo}/{numero}/", name="entidad_save_transportista_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveTransportistaAjaxAction(Request $request){
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('nombre',NULL);
        $doc_id = $request->get('doc_id',NULL);
        $direccion = $request->get('direccion','');
        $telefono = $request->get('telefono','');
        $lugar = $request->get('lugar',NULL);
        $certificado = $request->get('certificadoIdoneidad',NULL);
        $em = $this->getDoctrine()->getManager();
        $datos = array(
            'errors' => array(),
        );
        
        if($numero){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero));
            if($formato){
                $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($tipo)));
                if($tipo->getId() === $formato->getTipo()->getId()){
                    if($doc_id && $nombre){
                        $entidad = $this->getRepositorio()->createQueryBuilder('e')
                            ->leftJoin('e.usuario', 'u')
                            ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                            ->andWhere("u.docId= '".$doc_id."'")
                            ->getQuery()->getOneOrNullResult();
                        if(!$entidad){
                            $u = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->createQueryBuilder('u')
                                ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                                ->andWhere("u.docId= '".$doc_id."'")
                                ->getQuery()->getOneOrNullResult();
                            if(!$u){
                                $u = new Usuario();
                                $u->setNombre($nombre);
                                $u->setDocId($doc_id);
                                $u->setDireccion($direccion);
                                $u->setTelefono($telefono);
                                $em->persist($u);
                            }
                            $entidad = new Entidad();
                            $entidad->setCertificadoIdoneidad($certificado)
                                    ->setUsuario($u->setEntidad($entidad));
                            $lugar_pais = preg_split('/\s?,\s?/', $lugar);
                            if(count($lugar_pais) <= 2 && count($lugar_pais) > 1){
                                $pais = $em->getRepository('PuertoUDESCommonBundle:Pais')
                                        ->createQueryBuilder('p')
                                        ->andWhere('p.canonical LIKE \'%'.$lugar_pais[1].'%\' OR p.nombre LIKE \'%'.$lugar_pais[1].'%\'')
                                        ->getQuery()->getOneOrNullResult();
                                $l= $em->getRepository('PuertoUDESCommonBundle:Lugar')
                                        ->createQueryBuilder('p')
                                        ->andWhere('p.canonical = \''.$lugar_pais[0].'\' OR p.nombre = \''.$lugar_pais[0].'\'')
                                        ->getQuery()->getOneOrNullResult();
                                if((!$l || ($l && strtolower($l->getPais()->getNombre()) != strtolower($lugar_pais[1])) || ($l && $pais && $l->getPais()->getId() != $pais->getId())) && isset($lugar_pais[0]) && isset($lugar_pais[1])){
                                    $l = new \PuertoUDES\CommonBundle\Entity\Lugar();
                                    $l->setNombre($lugar_pais[0]);
                                    if(!$pais && isset($lugar_pais[1])){
                                        $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                                        $pais->setNombre($lugar_pais[1])
                                            ->setNacionalidad($lugar_pais[1]);
                                        $em->persist($pais);
                                        $l->setPais($pais);
                                    }
                                    $em->persist($l);
                                }
                                $entidad->setLugar($l);
                            }
                            $em->persist($entidad);
                        }
                        $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->findOneBy(array('canonical' => 'transportista', 'aplicableA' => 'FormatoUsuario'));
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->findOneBy(array('usuario' => $u->getId(), 'formato' => $formato->getId(), 'rol' => $rol->getId()));
                        if(!$fu){
                            $fu = new \PuertoUDES\FormatosBundle\Entity\FormatoUsuario();
                            $fu->setRol($rol)
                                ->setFormato($formato)
                                ->setUsuario($entidad->getUsuario());
                            $em->persist($fu);
                        }
                        $formato->setTransportista($entidad);
                        $em->persist($formato);
                        $em->flush();
                        $datos['success']['msgs']['Entidad'] = array(
                            'msg' => 'Entidad <strong>"'.$entidad->getNombre().'"</strong> fué creada',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $entidad->getId();
                    }else{
                        $datos['errors']['Entidad'] = 'Datos incompletos. Son necesarios El NIT y la Razón Social';
                        $datos['errors'] = array(
                            'tipo' => $request->get('tipo',NULL),
                            'numero' => $request->get('numero',NULL),
                            'nombre' => $request->get('nombre',NULL),
                            'doc_id' => $request->get('doc_id',NULL),
                            'direccion' => $request->get('direccion',NULL),
                            'telefono' => $request->get('telefono',NULL),
                            'lugar' => $request->get('lugar',NULL),
                            'certificado' => $request->get('certificadoIdoneidad',NULL),
                        );
                    }
                }else{
                    $datos['errors']['Formato'] = 'No Concuerda';
                }
            }
            else{
                $datos['errors']['Formato'] = 'No encontrado';
            }
        }
        else{
            $datos['errors']['Número de '.$tipo] = 'El Número de Entidad ya existe';
        }
        return JsonResponse::create($datos);
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
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'      =>  'Doc Id',
                        'label'     =>  'Documento de Identidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Descripcion',
                        'label'     =>  'Descripción',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Direccion',
                        'label'     =>  'Dirección',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Telefono',
                        'label'     =>  'Teléfono',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Certificado Idoneidad',
                        'label'     =>  'Certificado Idoneidad',
                        'join'     =>  'entidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'canonical',
                        'label'     =>  'Tipo de Documento de dentidad',
                        'join'     =>  'tipoDocId',
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
        return $this->getUtils()->getHeadFiltro($filas, $form, $route);
    }
}
