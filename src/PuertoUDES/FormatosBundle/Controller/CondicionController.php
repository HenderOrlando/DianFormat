<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\Condicion;
use PuertoUDES\FormatosBundle\Form\CondicionType;

/**
 * Condicion controller.
 *
 * @Route("/Condiciones")
 */
class CondicionController extends Controller
{

    /**
     * Lists all Condicion entities.
     *
     * @Route("/", name="condicion_formato_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:Condicion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Condicion entity.
     *
     * @Route("/", name="condicion_formato__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Condicion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Condicion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicion_formato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Condicion entity.
    *
    * @param Condicion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Condicion $entity)
    {
        $form = $this->createForm(new CondicionType(), $entity, array(
            'action' => $this->generateUrl('condicion_formato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/new", name="condicion_formato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Condicion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Condicion entity.
     *
     * @Route("/{id}", name="condicion_formato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Condicion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Condicion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Condicion entity.
     *
     * @Route("/{id}/edit", name="condicion_formato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Condicion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Condicion entity.');
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
    * Creates a form to edit a Condicion entity.
    *
    * @param Condicion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Condicion $entity)
    {
        $form = $this->createForm(new CondicionType(), $entity, array(
            'action' => $this->generateUrl('condicion_formato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Condicion entity.
     *
     * @Route("/{id}", name="condicion_formato__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Condicion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Condicion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Condicion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('condicion_formato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Condicion entity.
     *
     * @Route("/{id}", name="condicion_formato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Condicion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Condicion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('condicion_formato_'));
    }

    /**
     * Creates a form to delete a Condicion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('condicion_formato__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/{tipo}/Agregar/a/CPIC-{fila}/{numero}/", name="condiciones_add_cpic_ajax_")
     * @Route("/{tipo}/Agregar/a/CPIC/{numero}/", name="condiciones_add_cpic_ajax_")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:Formato:_addCondicionCpicAjax.html.twig")
     */
    public function addCondicionCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $role = $request->get('rol',NULL);
        $numero = $request->get('numero',NULL);
        $nombre = $request->get('nombre',NULL);
        $docId = $request->get('doc_id',NULL);
        $direccion = $request->get('direccion','');
        $lugar = $request->get('lugar',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic'));
        $entidad = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($docId && $nombre){
                    $entidad = $this->getRepositorio()->createQueryBuilder('e')
                        ->leftJoin('e.usuario', 'u')
                        ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                        ->andWhere("u.docId= '".$docId."'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$entidad){
                        $u = $em->getRepository('PuertoUDESUsuariosBundle:Usuario')->createQueryBuilder('u')
                            ->andWhere("u.canonical='".$nombre."' OR u.nombre='".$nombre."'")
                            ->andWhere("u.docId= '".$docId."'")
                            ->getQuery()->getOneOrNullResult();
                        if(!$u){
                            $u = new Usuario();
                            $u->setNombre($nombre)
                              ->setDocId($docId)
                              ->setDireccion($direccion);
                            $em->persist($u);
                            $em->flush();
                        }
                        $entidad = new Entidad();
                        $entidad->setUsuario($u->setEntidad($entidad));
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
                                if(!$l){
                                    $l = new \PuertoUDES\CommonBundle\Entity\Lugar();
                                    $l->setNombre($lugar_pais[0]);
                                    $em->persist($l);
                                }
                                if(!$pais && isset($lugar_pais[1])){
                                    $pais = new \PuertoUDES\CommonBundle\Entity\Pais();
                                    $pais->setNombre($lugar_pais[1])
                                        ->setNacionalidad($lugar_pais[1]);
                                    $em->persist($pais);
                                }
                                if(!$pais->hasLugar($l)){
                                    $pais->addLugar($l);
                                    $em->persist($pais);
                                }
                                if(!$l->getPais() || $l->getPais()->getId() != $pais->getId()){
                                    $l->setPais($pais);
                                    $em->persist($l);
                                }
                                $entidad->setLugar($l);
                                $l->addEntidad($entidad);
                                $em->persist($l);
                        }
                        $u->setEntidad($entidad);
                        $em->persist($u);
                        $em->persist($entidad);
                    }
                    
                    $rol = $em->getRepository('PuertoUDESCommonBundle:Rol')->createQueryBuilder('r')
                            ->andWhere("r.canonical='".$role."' OR r.nombre='".$role."'")
                            ->getQuery()->getOneOrNullResult();
                    if(!$rol /*&& !empty($role)*/ || empty($role) ){
                        $datos['success']['msgs']['Formato'] = array(
                            'msg' => 'Rol no reconocido',
                            'tipo' => 'danger'
                        );
                        
//                        $rol = new \PuertoUDES\CommonBundle\Entity\Rol();
//                        $rol->setDescripcion('Rol '.$role.' de la Entidad, en Formato Usuario')
//                            ->setAplicableA('FormatoUsuario')
//                            ->setNombre($role);
//                        $em->persist($rol);
                    }else{
                        $fu = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->createQueryBuilder('fu')
                                ->andWhere("fu.usuario=".$u->getId())
                                ->andWhere("fu.rol=".$rol->getid())
                                ->getQuery()->getOneOrNullResult();
                        if(!$fu){
                            $fu = new \PuertoUDES\FormatosBundle\Entity\FormatoUsuario();
                            $fu->setFormato($formato);
                            $fu->setUsuario($u);
                            $fu->setRol($rol);
                            $em->persist($fu);
                        }else{
                            
                        }
                        $em->flush();
                        $datos['success']['msgs']['Formato'] = array(
                            'msg' => 'Entidad '.($role == 'notificar'?'a notificar':str_replace('tario', 'taria', $role)).' <strong>"'.$entidad->getNombre().'"</strong> agregada.',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $fu->getId();
                    }
                    return JsonResponse::create($datos);
                }else{

                }
            }else{
                $datos['success']['msgs']['Formato'] = array(
                    'msg' => 'Formato no válido',
                    'tipo' => 'danger'
                );
                return JsonResponse::create($datos);
            }
        }
        return array(
            'fila'          => $filas,
            'abreviacion'   =>  $formato->getTipo()->getAbreviacion(),
            'numero'        =>  $formato->getNumero(),
            'entidad'       =>  $entidad,
            'rol'           =>  $role,
        );
    }
}
