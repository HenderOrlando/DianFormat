<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Vehiculo;
use PuertoUDES\CommonBundle\Form\VehiculoType;

/**
 * Vehiculo controller.
 *
 * @Route("/vehiculo_")
 */
class VehiculoController extends Controller
{

    /**
     * Lists all Vehiculo entities.
     *
     * @Route("/", name="vehiculo_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Vehiculo entity.
     *
     * @Route("/", name="vehiculo__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Vehiculo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vehiculo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vehiculo__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Vehiculo entity.
    *
    * @param Vehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Vehiculo $entity)
    {
        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vehiculo entity.
     *
     * @Route("/new", name="vehiculo__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vehiculo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Vehiculo entity.
     *
     * @Route("/{id}/edit", name="vehiculo__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
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
    * Creates a form to edit a Vehiculo entity.
    *
    * @param Vehiculo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vehiculo $entity)
    {
        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Vehiculo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehiculo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vehiculo__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Vehiculo entity.
     *
     * @Route("/{id}", name="vehiculo__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Vehiculo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vehiculo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vehiculo_'));
    }

    /**
     * Creates a form to delete a Vehiculo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vehiculo__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
