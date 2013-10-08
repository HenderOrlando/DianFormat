<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\PermisoPresentaServicio;
use PuertoUDES\FormatosBundle\Form\PermisoPresentaServicioType;

/**
 * PermisoPresentaServicio controller.
 *
 * @Route("/permisoPresentaServicio_")
 */
class PermisoPresentaServicioController extends Controller
{

    /**
     * Lists all PermisoPresentaServicio entities.
     *
     * @Route("/", name="permisoPresentaServicio_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PermisoPresentaServicio entity.
     *
     * @Route("/", name="permisoPresentaServicio__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:PermisoPresentaServicio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PermisoPresentaServicio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('permisoPresentaServicio__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PermisoPresentaServicio entity.
    *
    * @param PermisoPresentaServicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PermisoPresentaServicio $entity)
    {
        $form = $this->createForm(new PermisoPresentaServicioType(), $entity, array(
            'action' => $this->generateUrl('permisoPresentaServicio__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PermisoPresentaServicio entity.
     *
     * @Route("/new", name="permisoPresentaServicio__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PermisoPresentaServicio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PermisoPresentaServicio entity.
     *
     * @Route("/{id}/edit", name="permisoPresentaServicio__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
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
    * Creates a form to edit a PermisoPresentaServicio entity.
    *
    * @param PermisoPresentaServicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PermisoPresentaServicio $entity)
    {
        $form = $this->createForm(new PermisoPresentaServicioType(), $entity, array(
            'action' => $this->generateUrl('permisoPresentaServicio__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:PermisoPresentaServicio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('permisoPresentaServicio__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PermisoPresentaServicio entity.
     *
     * @Route("/{id}", name="permisoPresentaServicio__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:PermisoPresentaServicio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PermisoPresentaServicio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('permisoPresentaServicio_'));
    }

    /**
     * Creates a form to delete a PermisoPresentaServicio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('permisoPresentaServicio__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
