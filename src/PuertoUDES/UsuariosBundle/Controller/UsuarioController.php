<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\UsuariosBundle\Entity\Usuario;
use PuertoUDES\UsuariosBundle\Form\UsuarioType;
use PuertoUDES\UsuariosBundle\Form\UsuarioComunType;

/**
 * Usuario controller.
 *
 * @Route("/Usuario")
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario_")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function indexAction(Request $request, $config = null)
    {
        $title = 'Usuarios';
        $entity = 'Usuario';
        $bundle = 'Common';
        $route = 'usuario_';
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
        $new_route = $this->generateUrl('usuario__new_',array('rol' => $title, 'id' => $this->getUser()->getId()));
        if($title === 'Usuarios'){
            $new_route = $this->generateUrl('usuario__new',array('rol' => $title, 'id' => $this->getUser()->getId()));
        }
        $botones = array(
            array(
                'url'   => $new_route,
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
     * Creates a new Usuario entity.
     *
     * @Route("/estudiantes/", name="usuario__estudiantes")
     * @Route("/estudiantes/", name="usuario__estudiante")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function estudiantesAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Estudiantes',
            'entity'    =>  'Usuario',
            'bundle'    =>  'Usuarios',
            'route'     =>  'usuario__estudiantes',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getEstudiantes(false, true),
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/docentes/", name="usuario__docentes")
     * @Route("/docentes/", name="usuario__docente")
     * @Method({"GET"})
     * @Template("PuertoUDESCommonBundle:Plantilla:menu.html.twig")
     */
    public function docentesAction(Request $request){
        return $this->indexAction($request, array(
            'title'     =>  'Docentes',
            'entity'    =>  'Usuario',
            'bundle'    =>  'Usuarios',
            'route'     =>  'usuario__docentes',
            'limit'     =>  10,
            'qb'        =>  $this->getRepositorio()->getDocentes(false, true),
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/{id}/rol/{rol}", name="usuario__create_")
     * @Route("/{id}/", name="usuario__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Usuario:new.html.twig")
     */
    public function createAction(Request $request, $id, $rol = 'Usuarios')
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity, $id, $rol);
        $form->handleRequest($request);

        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $user = $em->getRepository('PuertoUDESFosUsuarioBundle:FosUser')->find($id);
//            if(!$user){
                $userManager = $this->container->get('fos_user.user_manager');
                $user = $userManager->createUser();
//                
//                $encoder_service = $this->get('security.encoder_factory');
//                $encoder = $encoder_service->getEncoder($user);
//                $encoded_pass = $encoder->encodePassword($entity->getDocId(), $user->getSalt());
                
                $user->setUsername($entity->getDocId());
                $user->setEnabled(true);
                $user->setPlainPassword($entity->getDocId());
                $user->setEmail(str_replace('-', '_', $entity->getCanonical()).'@example.com');
                
                $userManager->updateUser($user,false);
//            }
            $em->persist($entity);
            $em->flush();
            $user->setUsuario($entity);
            $em->persist($user);
            $em->flush();
            

            return $this->redirect($this->generateUrl('usuario__show', array('id' => $entity->getId())));
        }
        $template = 'new';
        $parametros = array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
        if($request->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nuevos '.$rol,
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }

        return $parametros;
    }

    /**
    * Creates a form to create a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Usuario $entity, $id = -1, $rol = null)
    {
        if($rol !== 'usuario'){
            $em = $this->getDoctrine()->getManager();
            $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                ->andWhere("r.canonical LIKE '%".$rol."%' OR r.nombre LIKE '%".$rol."%'")
                ->andWhere("r.aplicableA LIKE '%Usuario%'")
                ->getQuery()->getOneOrNullResult();
            if($rol){
                $rolName = $rol->getCanonical();
            }
        }else{
            $rolName = $rol;
            $rol = null;
        }
        $form = $this->createForm(new UsuarioType($this->getUser(), $rol), $entity, array(
            'action' => $this->generateUrl('usuario__create_',array('id' => $id, 'rol' => $rolName)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create', 'attr' => array('data-reload' => $this->generateUrl('usuario_'.($rolName !== 'usuario'?'_'.$rol->getCanonical():''),array(),true))));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new/{id}/rol/{rol}", name="usuario__new_", defaults={"id":"-1"})
     * @Route("/new/{id}/", name="usuario__new", defaults={"id":"-1"})
     * @Method({"GET","POST"})
     * @Template()
     */
    public function newAction($id, $rol = 'usuario')
    {
        switch($rol){
            case 'Estudiantes':
                $rol = 'estudiante';
                break;
            case 'Docentes':
                $rol = 'docente';
                break;
        }
        $entity = new Usuario();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PuertoUDESFosUsuarioBundle:FosUser')->find($id);
        if($user){
            $form   = $this->createCreateForm($entity, $id, $rol);
        }else{
            return $this->redirect($this->generateUrl('fos_user_registration_register'));
        }

        $template = 'new';
        $parametros = array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => 'Agregar Nuevo '.ucfirst($rol),
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuario__show")
     * @Route("/{id}/rol/{rol}/", name="usuario__show_")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $template = 'show';
        $parametros = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => $entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESUsuariosBundle:Usuario:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario__edit")
     * @Route("/{id}/edit/rol/{rolName}", name="usuario__edit_rolname")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $rolName = 'usuario')
    {
        $em = $this->getDoctrine()->getManager();

//        $fos = $em->getRepository('PuertoUDESFosUsuarioBundle:FosUser')->find($id);
        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->find($id);

        if (!$entity) {
//            $entity = $em->getRepository('PuertoUDESFosUsuarioBundle:FosUser')->find($id);
//            if (!$entity || !$entity->getUsuario()) {
                return $this->redirect($this->generateUrl('usuario__new', array(
                    'id'    =>  $id
                )));
//            //throw $this->createNotFoundException('Unable to find Usuario entity.');
//            }else{
//                $entity = $entity->getUsuario();
//            }
        }
        
        $editForm = $this->createEditForm($entity, $rolName);
        $deleteForm = $this->createDeleteForm($id);

        $parametros = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        $template = 'edit';
        if($this->getRequest()->isXmlHttpRequest()){
            return JsonResponse::create(array(
                'title' => $entity->getNombre(),
                'body'  => $this->renderView('PuertoUDESCommonBundle:Plantilla:_'.$template.'.html.twig', $parametros),
            ));
        }
        return $parametros;
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity, $rolName = 'usuario')
    {
        $sc = $this->get('security.context');
        $type = null;
        if(false === $sc->isGranted('ROLE_ADMIN') && false === $sc->isGranted('ROLE_SUPER_ADMIN')){
            $type = new UsuarioComunType();
        }else{
            $url = '';
            $datos = array('id' => $entity->getId());
            if($rolName !== 'usuario'){
                $datos['rolName'] = $rolName;
                $url = '_rolname';
            }
            if($entity->hasRol('Estudiante')){
                $rol = 'Estudiante';
                $em = $this->getDoctrine()->getManager();
                $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                    ->andWhere("r.canonical LIKE '%".$rol."%' OR r.nombre LIKE '%".$rol."%'")
                    ->andWhere("r.aplicableA LIKE '%Usuario%'")
                    ->getQuery()->getOneOrNullResult();
            }else{
                $rol = null;
            }
            $type = new UsuarioType($this->getUser(), $rol);
        }
        $form = $this->createForm($type, $entity, array(
            'action' => $this->generateUrl('usuario__update'.$url, $datos),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('data-reload' => $this->generateUrl('usuario_'.($rolName !== 'usuario'?'_'.$rolName:''),array(),true))));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}", name="usuario__update")
     * @Route("/{id}/rol/{rolName}", name="usuario__update_rolname")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Usuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $rolName = 'usuario')
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->find($id);
        
        $url = '';
        $datos = array('id' => $entity->getId());
        if($rolName !== 'usuario'){
            $datos['rolName'] = $rolName;
            $url = '_rolname';
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $rolName);
        $editForm = $this->createEditForm($entity, $rolName);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usuario__edit'.$url, $datos));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="usuario__delete")
     * @Route("/{id}/{rolName}", name="usuario__delete_rolname")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->find($id);
        
        $rol = $entity->getRoles()->first();
        $rolName = $rol->getCanonical();
        
        $form = $this->createDeleteForm($id, $rolName);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $fos = $em->getRepository('PuertoUDESFosUsuarioBundle:FosUser')->findOneBy(array('usuario' => $entity));
//            $msg = "El usuario ".$entity->getNombre()." fué borrado.";
            $msg = "El usuario ".$entity->getNombre()." ha sido inhabilitado.";
            $titulo = "Inhabilitado";
            if (!$entity) {
                $msg = 'El usuario no ha sido encontrado';
            }else{
                $fos->setEnabled(false);
                if($entity->canDelete()){
    //                if($entity){
    //                    $em->remove($entity);
    //                }
    //                if($fos){
    //                    $em->remove($fos);
    //                }
                    $em->flush();
                }else{
                    $msg = "Sitio(s) donde puede encontrarse:";
    //                $titulo = 'Inhabilitado';
    //                if($fos){
    //                    $fos->setEnabled(false);
    //                }
    //                $msg = "El usuario ".$entity->getNombre()." no puede borrarse. Es posible que tenga formatos asociados a él. En su lugar se inhabilitó, por tanto no podrá iniciar sesión.";
                    $msgs = $entity->whyCanDelete();
                    if(!empty($msg)){
                        $msg .= '<ul>';
                        foreach($msgs as $msg_){
                            $msg .= '<li>'.$msg_.'</li>';
                        }
                        $msg .= '</ul>';
                    }
                }
                if($request->isXmlHttpRequest()){
                    return JsonResponse::create(array(
                        'title' => "Usuario ".$titulo,
                        'body'  => $msg,
                    ));
                }
            }
            
        }
        

        return $this->redirect($this->generateUrl('usuario_'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id, $rolName = 'usuario')
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('data-reload' => $this->generateUrl('usuario_'.($rolName !== 'usuario'?'_'.$rolName:''),array(),true))))
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
     * @return UsuarioRepository  UsuarioRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESUsuariosBundle:Usuario');
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
                                'url'   => 'usuario__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'class'  => 'carga-modal',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'usuario__delete',
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
