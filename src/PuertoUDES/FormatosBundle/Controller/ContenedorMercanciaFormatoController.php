<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato;
use PuertoUDES\FormatosBundle\Form\ContenedorMercanciaFormatoType;

/**
 * ContenedorMercanciaFormato controller.
 *
 * @Route("/contenedorMercanciaFormato_")
 */
class ContenedorMercanciaFormatoController extends Controller
{

    /**
     * Lists all ContenedorMercanciaFormato entities.
     *
     * @Route("/", name="contenedorMercanciaFormato_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ContenedorMercanciaFormato entity.
     *
     * @Route("/", name="contenedorMercanciaFormato__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:ContenedorMercanciaFormato:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ContenedorMercanciaFormato();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenedorMercanciaFormato__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ContenedorMercanciaFormato entity.
    *
    * @param ContenedorMercanciaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ContenedorMercanciaFormato $entity)
    {
        $form = $this->createForm(new ContenedorMercanciaFormatoType(), $entity, array(
            'action' => $this->generateUrl('contenedorMercanciaFormato__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContenedorMercanciaFormato entity.
     *
     * @Route("/new", name="contenedorMercanciaFormato__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContenedorMercanciaFormato();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}/edit", name="contenedorMercanciaFormato__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
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
    * Creates a form to edit a ContenedorMercanciaFormato entity.
    *
    * @param ContenedorMercanciaFormato $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContenedorMercanciaFormato $entity)
    {
        $form = $this->createForm(new ContenedorMercanciaFormatoType(), $entity, array(
            'action' => $this->generateUrl('contenedorMercanciaFormato__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:ContenedorMercanciaFormato:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contenedorMercanciaFormato__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ContenedorMercanciaFormato entity.
     *
     * @Route("/{id}", name="contenedorMercanciaFormato__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:ContenedorMercanciaFormato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContenedorMercanciaFormato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenedorMercanciaFormato_'));
    }

    /**
     * Creates a form to delete a ContenedorMercanciaFormato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contenedorMercanciaFormato__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
