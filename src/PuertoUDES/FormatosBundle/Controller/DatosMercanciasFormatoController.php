<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use PuertoUDES\CommonBundle\Controller\IndexController;
use PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato;
use PuertoUDES\FormatosBundle\Repository\DatosMercanciasFormatoRepository;
use PuertoUDES\FormatosBundle\Form\DatosMercanciasFormatoType;

/**
 * DatosMercanciasFormato controller.
 *
 * @Route("/Datos-Mercancias")
 */
class DatosMercanciasFormatoController extends Controller
{

    /**
     * Lists all DatosMercanciasFormato entities.
     *
     * @Route("/", name="datosMercancias")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DatosMercanciasFormato entity.
     *
     * @Route("/", name="datosMercancias_create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:DatosMercanciasFormato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DatosMercanciasFormato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosMercancias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a DatosMercanciasFormato entity.
    *
    * @param DatosMercanciasFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(DatosMercanciasFormato $entity)
    {
        $form = $this->createForm(new DatosMercanciasFormatoType(), $entity, array(
            'action' => $this->generateUrl('datosMercancias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosMercanciasFormato entity.
     *
     * @Route("/new", name="datosMercancias_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DatosMercanciasFormato();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a DatosMercanciasFormato entity.
     *
     * @Route("/{id}", name="datosMercancias_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosMercanciasFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DatosMercanciasFormato entity.
     *
     * @Route("/{id}/edit", name="datosMercancias_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosMercanciasFormato entity.');
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
    * Creates a form to edit a DatosMercanciasFormato entity.
    *
    * @param DatosMercanciasFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosMercanciasFormato $entity)
    {
        $form = $this->createForm(new DatosMercanciasFormatoType(), $entity, array(
            'action' => $this->generateUrl('datosMercancias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosMercanciasFormato entity.
     *
     * @Route("/{id}", name="datosMercancias_update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:DatosMercanciasFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosMercanciasFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosMercancias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a DatosMercanciasFormato entity.
     *
     * @Route("/{id}", name="datosMercancias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosMercanciasFormato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosMercancias'));
    }

    /**
     * Creates a form to delete a DatosMercanciasFormato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosMercancias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to create a new Condicion entity.
     *
     * @Route("/{tipo}/Agregar/a/CPIC-{fila}/{numero}/", name="datosMercancias_add_cpic_ajax_")
     * @Route("/{tipo}/Agregar/a/CPIC/{numero}/", name="datosMercancias_add_cpic_ajax_")
     * @Method({"POST","PUT"})
     * @Template("PuertoUDESFormatosBundle:DatosMercanciasFormato:_addDatosMercanciasAjax.html.twig")
     */
    public function addDatosMercanciasCpicAjaxAction(Request $request){
        $filas = $request->get('filas', 0);
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $fecha = $request->get('fecha',NULL);
        $lugar = $request->get('lugar',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => 'cpic', 'aplicableA' => 'Formato'));
        $dmf = null;
        $datos = array();
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                if($tipo && strstr($lugar,',') !== false){
                    $dmf = $this->getRepositorio()->createQueryBuilder('dmf')
                        ->leftJoin('dmf.formato', 'f')
                        ->innerJoin('dmf.tipo', 't')
                        ->andWhere("f.numero='".$numero."'")
                        ->andWhere("t.canonical LIKE '%".$tipo."%' OR t.nombre LIKE '%".$tipo."%'")
                        ->getQuery()->getOneOrNullResult();
                    if(!$dmf){
                        $dmf = new DatosMercanciasFormato();
                        $date = date('Y-m-d H:i:s',strtotime($fecha.' '.date('H:i:s')));
                        $dmf->setFecha(new \DateTime($date));
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
                                $dmf->setLugar($l);
                                $l->addDatosMercanciasFormato($dmf);
                                $em->persist($l);
                        }
                        $em->persist($dmf);
                    }
                    $tipo_ = $tipo;
                    $tipo = $em->getRepository('PuertoUDESCommonBundle:Tipo')->createQueryBuilder('t')
                            ->andWhere("t.canonical='".$tipo."' OR t.nombre='".$tipo."'")
                            ->andWhere("t.aplicableA LIKE '%datosMercancias%'")
                            ->getQuery()->getOneOrNullResult();
                    if(!$tipo /*&& !empty($role)*/ || empty($tipo) ){
                        $datos['errors'][$tipo_.' Mercancias'] = 'Tipo no reconocido';
                    }else{
                        $dmf->setFormato($formato)
                            ->setTipo($tipo);
                        $em->persist($dmf);
                        $em->flush();
                        $datos['success']['msgs']['Formato'] = array(
                            'msg' => 'Datos de'.$tipo->getNombre().' de las Mercancías agregados.',
                            'tipo' => 'success'
                        );
                        $datos['id'] = $dmf->getId();
                    }
                    return JsonResponse::create($datos);
                }else{
                    $datos['success']['msgs']['Formato'] = array(
                        'msg' => 'Datos incompletos, Falta definir el Lugar',
                        'tipo' => 'danger'
                    );
                }
            }else{
                $datos['errors'][$tipo.' Mercancias'] = 'Datos no válidos';
            }
            return JsonResponse::create($datos);
        }
        return array(
            'fila'          =>  $filas,
            'abreviacion'   =>  $formato->getTipo()->getAbreviacion(),
            'numero'        =>  $formato->getNumero(),
            'dmf'           =>  $dmf,
            'tipo'          =>  $tipo,
        );
    }
    
    /**
     * Displays a form to create a new Formato entity.
     *
     * @Route("/Reset/{tipo}-{pk}/en/{abreviacion}-{numero}/", name="datosMercancias_ajax_reset_")
     * @Route("/Reset/{tipo}/en/{abreviacion}-{numero}/", name="datosMercancias_ajax_reset")
     * @Method({"DELETE"})
     * @Template()
     */
    public function resetAjaxAction(Request $request){
        if(!$request->isXmlHttpRequest())
            throw $this->createNotFoundException('Lo siento, la Página no existe');
        $tipo = $request->get('tipo',NULL);
        $numero = $request->get('numero',NULL);
        $abreviacion = strtolower($request->get('abreviacion',NULL));
        $pk = $request->get('pk',NULL);
        $em = $this->getDoctrine()->getManager();
        $tipo_mci = $em->getRepository('PuertoUDESCommonBundle:Tipo')->findOneBy(array('abreviacion' => $abreviacion));
        $datos = array(
            'pk'            =>  $pk,
            'numero'        =>  $numero,
            'tipo'           =>  $tipo,
            'abreviacion'   =>  $abreviacion,
        );
        if($tipo_mci){
            $formato = $em->getRepository('PuertoUDESFormatosBundle:Formato')->findOneBy(array('tipo' => $tipo_mci->getId(), 'numero' => $numero));
            if($formato){
                $obj = $em->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato')->find($pk);
                if($obj){
                    $em->remove($obj);
                    $em->flush();
                    $datos['msgs']['Formato'] = array(
                        'msg' => 'Eliminado'.($tipo?' '.$tipo.' ':' ').$obj->__toString(),
                        'tipo' => 'success'
                    );
                }else{
                    $datos['msgs']['Formato'] = array(
                        'msg' => 'Ya está limpio',
                        'tipo' => 'danger'
                    );
                }
            }else{
                $datos['msgs']['Formato'] = array(
                    'msg' => 'Formato no válido',
                    'tipo' => 'danger'
                );
            }
        }else{
            $datos['msgs']['Formato'] = array(
                'msg' => 'Tipo de Formato no válido',
                'tipo' => 'danger'
            );
        }
        return JsonResponse::create($datos);
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
     * @return DatosMercanciasFormatoRepository  DatosMercanciasFormatoRepository de PuertoUDES
     */
    public function getRepositorio() {
        return $this->getDoctrine()->getManager()->getRepository('PuertoUDESFormatosBundle:DatosMercanciasFormato');
    }
    
    public function getHeadFiltro(FormBuilder $form, $route){
        $filas = array(
            array(
                'col'=>array(
                    array(
                        'dato'      =>  'Formato',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Lugar',
                        'class' =>  'text-center',
                    ),
                    array(
                        'dato'    =>   'Fecha',
                        'class' =>  'text-center',
                    ),
//                    array(
//                        'dato'    =>  'canonical',
//                        'label'   =>  'Tipo de Documento de dentidad',
//                        'join'    =>  'tipoDocId',
//                        'class' =>  'text-center',
//                    ),
                    array(
                        'dato'    =>   'Acciones',
                        'class' =>  'text-center',
                        'acciones'=>    array(
                            array(
                                'url'   => 'datosMercancias__edit',
                                'data_url'=> array('id'),
                                'type'  => 'default',
                                'label' => '<span class="glyphicon glyphicon-pencil" ></span> Editar',
                            ),
                            array(
                                'url'   => 'datosMercancias__delete',
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
