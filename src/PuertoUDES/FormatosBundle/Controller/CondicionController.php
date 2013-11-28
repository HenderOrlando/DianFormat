<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
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
        $nom = $request->get('name',NULL);
        $valor = $request->get('value',NULL);
        $llave = $request->get('pk',NULL);
        $tipo = $request->get('tipo',NULL);
        
        $filas = $request->get('filas', 0);
        $numero = $request->get('numero',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic'));
        $entidad = null;
//        $datos = array(
//            'name'   =>    $nom,
//            'value'  =>    $valor,
//            'pk'     =>    $llave,
//            'save'   =>    $save,
//            'entity' =>    $entity,
//            'bundle' =>    $bundle,
//            'values' =>    array(
//                'fila'          =>  $filas,
//                'tipo'           =>  $tipo,
//                'numero'        =>  $numero,
//            ),
//        );
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($valor){
                    $tipo_condicion = $em->getRepository('PuertoUDESCommonBundle:Tipo')->createQueryBuilder('t')
                        ->andWhere("t.canonical LIKE '%".$tipo."%' OR t.nombre LIKE '%".$tipo."%'")
                        ->andWhere("t.aplicableA LIKE '%condicion%'")
                        ->getQuery()->getOneOrNullResult();
                    if($tipo_condicion){
                        $condicion = null;
                        if($llave && $llave != ' '){
                            $condicion = $this->getRepositorio()->find($llave);
                        }
                        if(!$condicion){
                            $condicion = new Condicion();
                            $condicion->setCondicion($valor)
                              ->setFormato($formato)
                              ->setTipo($tipo_condicion);
                            $em->persist($condicion);
                            $em->flush();
                        }else{
                            $condicion->setCondicion($valor);
                            $em->persist($condicion);
                        }
                        $formato->addCondicion($condicion);
                        $em->persist($formato);
                        $em->flush();
                        $datos['msgs'][] = array(
                            'msg' => 'Condicion de '.$tipo.' fué creada',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $condicion->getId();
                        $datos['value'] = $condicion->getCondicion();
                        $datos['datos'] = $condicion->json(false);
                    }else{
                        $datos['success']['msgs']['Condicion'] = array(
                            'msg' => 'Tipo de Condición "'.$tipo.'" no reconocido',
                            'tipo' => 'danger'
                        );
                    }
                    return JsonResponse::create($datos);
                }
            }else{
                $datos['success']['msgs']['Formato'] = array(
                    'msg' => 'Formato no válido',
                    'tipo' => 'danger'
                );
            }
            return JsonResponse::create($datos);
        }
        $datos = array(
            'fila'          => $filas,
            'abreviacion'   =>  $formato->getTipo()->getAbreviacion(),
            'numero'        =>  $formato->getNumero(),
            'entidad'       =>  $entidad,
            'rol'           =>  $role,
        );
        if($request->isXmlHttpRequest())
            return JsonResponse::create($datos);
        return $datos;
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
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:Condicion');
    }
}
