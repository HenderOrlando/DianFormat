<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\UsuariosBundle\Entity\Conductor;
use PuertoUDES\UsuariosBundle\Entity\Usuario;
use PuertoUDES\UsuariosBundle\Form\ConductorType;

/**
 * Conductor controller.
 *
 * @Route("/Conductor")
 */
class ConductorController extends Controller
{

    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Lista/para/{name}/", name="list_typeahead_conductores_")
     * @Template()
     */
    public function listTypeaheadAction(Request $request){
        $list = array();
        $entities = $this->getRepositorio()->findAll();
        $name = $request->get('name','');
        $propertyPath = new PropertyAccessor();
        foreach($entities as $conductor){
            $value = $propertyPath->getValue($conductor,$name);
            if(is_null($value))
                $value = '';
            elseif(is_object($value))
                $value = $value->__toString();
            $list[] = array(
                'value' =>  $value,
                'tokens'=>  $conductor->getTokens(),
                'datos' =>  $conductor->json(false)
            );
        }
        if($name === 'nacionalidad')
            return JsonResponse::create($this->listTypeaheadPaises($list));
        return JsonResponse::create($list);
    }
    public function listTypeaheadPaises($list = array()){
        $entities = $this->getDoctrine()->getManager()->getRepository('PuertoUDESCommonBundle:Pais')->findAll();
        foreach($entities as $pais){
            $list[] = array(
                'value' =>  $pais->getNacionalidad(),
                'tokens'=>  $pais->getTokens(),
                'datos' =>  $pais->json(false)
            );
        }
        return $list;
    }
    /**
     * Lists all Conductor entities.
     *
     * @Route("/", name="conductor_")
     * @Route("/", name="Conductor_")
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
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/{tipo_conductor}/Guardar/{tipo}/{numero}/", name="conductor_save_ajax")
     * @Method({"POST","PUT"})
     * @Template()
     */
    public function saveTransportistaAjaxAction(Request $request){
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $tipoConductor = $request->get('tipo_conductor',NULL);
        $nombre = $request->get('nombre',NULL);
        $apellido = $request->get('apellido',NULL);
        $doc_id = $request->get('docId',NULL);
        $nacionalidad = $request->get('nacionalidad',null);
        $numLicencia = $request->get('numLicencia',null);
        $numLibreta = $request->get('numLibretaTripulante',NULL);
        $em = $this->getDoctrine()->getManager();
        $datos = array(
            'errors' => array(),
        );
        $datos['valores'] = array(
            'tipo Formato' => $tipo,
            'numero Formato' => $numero,
            'tipoConductor' => $tipoConductor,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'doc Id' => $doc_id,
            'nacionalidad' => $nacionalidad,
            'licencia' => $numLicencia,
            'libreta' => $numLibreta,
        );
        if($numero){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('numero' => $numero));
            if($formato){
                $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => strtolower($tipo)));
                if($tipo->getId() === $formato->getTipo()->getId()){
                    if($doc_id && $nombre && $numLicencia){
                        $conductor = $this->getRepositorio()->createQueryBuilder('e')
                            ->leftJoin('e.usuario', 'u')
                            ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                            ->andWhere("u.docId= '".$doc_id."'")
                            ->getQuery()->getOneOrNullResult();
                        if(!$conductor){
                            $u = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->createQueryBuilder('u')
                                ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                                ->andWhere("u.docId= '".$doc_id."'")
                                ->getQuery()->getOneOrNullResult();
                            if(!$u){
                                $u = new Usuario();
                                $u->setNombre($nombre)
                                  ->setApellido($apellido)
                                  ->setDocId($doc_id);
                                $em->persist($u);
                            }
                            $conductor = new Conductor();
                            $conductor->setNumLibretaTripulante($numLibreta)
                                    ->setNumLicencia($numLicencia)
                                    ->setUsuario($u->setConductor($conductor));
                            
                            $pais = $em->getRepository('PuertoUDESCommonBundle:Pais')
                                    ->createQueryBuilder('p')
                                    ->andWhere("p.canonical LIKE '%".$nacionalidad."%' OR p.nombre LIKE '%".$nacionalidad."%' OR p.nacionalidad LIKE '%".$nacionalidad."%'")
                                    ->getQuery()->getOneOrNullResult();
                            if(!$pais){
                                $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                                $pais->setNombre($nacionalidad)
                                    ->setNacionalidad($nacionalidad);
                                $em->persist($pais);
                            }
                            $conductor->setPais($pais);
                            $em->persist($conductor);
                        }
                        $fc = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')
                            ->createQueryBuilder('fc')
                            ->innerJoin('fc.conductor','c')
                            ->andWhere('fc.formato = '.$formato->getId())
                            ->andWhere('c.numLicencia LIKE \'%'.$numLicencia.'%\'')
                            ->andWhere('c.numLibretaTripulante LIKE \'%'.$numLibreta.'%\'')
                            ->getQuery()->execute();
                        if(!$fc){
                            $fc = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')
                                ->createQueryBuilder('fc')
                                ->andWhere('fc.formato = '.$formato->getId())
                                ->andWhere('fc.conductor IS NULL')
                                ->andWhere('fc.vehiculo IS NOT NULL')
                                ->getQuery()->getOneOrNullResult();
                            if(!$fc){
                                $fc = new \PuertoUDES\FormatosBundle\Entity\FormatoConductor();
                                $fc->setFormato($formato);
                            }
                            $fc->setEsAuxiliar($tipoConductor == 'Auxiliar')
                                ->setConductor($conductor);
                            $em->persist($fc);
                            
                            $formato->addConductor($fc);
                            $em->persist($formato);
                            $em->flush();
                            $datos['success']['msgs']['Conductor'] = array(
                                'msg' => 'Conductor <strong>"'.$conductor->getNombre().'"</strong> fué creada',
                                'tipo' => 'success'
                            );
                        }else{
                            $datos['success']['msgs']['Conductor'] = array(
                                'msg' => 'El Conductor <strong>"'.$conductor->getNombre().'"</strong> ya existe en éste formulario.',
                                'tipo' => 'success'
                            );
                            //actualiza campos
                        }
                        $datos['id'] = $conductor->getId();
                    }else{
                        $datos['errors']['Conductor'] = 'Datos incompletos. Son necesarios <br/><ul><li>El Nombre</li><li>El Documento de Identidad</li><li>La Licencia de Conducción</li><li>La Nacionalidad</li></ul>';
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
            $datos['errors']['Número de '.$tipo] = 'El Formato no existe';
        }
        return JsonResponse::create($datos);
    }
    
    /**
     * Creates a new Conductor entity.
     *
     * @Route("/", name="conductor__create")
     * @Route("/", name="Conductor__create")
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

        $template = 'new';
        $parametros = array(
            'entity'      => $entity,
            'form' => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => 'Agregar Nuevo Conductor',
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
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

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                'title' => empty($entity->getNombre())?$entity->getDescripcion():$entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESUsuariosBundle:Conductor:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
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
     * @Route("/{id}", name="Conductor__update")
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
     * @Route("/{id}", name="Conductor__delete")
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
                        'dato'      =>  'DocId',
                        'label'     =>  'Documento de Identidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Nombre',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Direccion',
                        'label'     =>  'Dirección',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'telefono',
                        'label'     =>  'Teléfono',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'pais',
                        'label'    =>   'Nacionalidad',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'claseLicencia',
                        'label'    =>   'Clase de Licencia de Conducción',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'NumLicencia',
                        'label'    =>   'Número de Licencia',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'NumLibretaTripulante',
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
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'conductor__delete',
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
