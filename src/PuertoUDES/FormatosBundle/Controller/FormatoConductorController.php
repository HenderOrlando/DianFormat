<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\FormatoConductor;
use PuertoUDES\FormatosBundle\Form\FormatoConductorType;

/**
 * FormatoConductor controller.
 *
 * @Route("/formatoConductor_")
 */
class FormatoConductorController extends Controller
{

    /**
     * Lists all FormatoConductor entities.
     *
     * @Route("/", name="formatoConductor_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FormatoConductor entity.
     *
     * @Route("/", name="formatoConductor__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:FormatoConductor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FormatoConductor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formatoConductor__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FormatoConductor entity.
    *
    * @param FormatoConductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FormatoConductor $entity)
    {
        $form = $this->createForm(new FormatoConductorType(), $entity, array(
            'action' => $this->generateUrl('formatoConductor__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FormatoConductor entity.
     *
     * @Route("/new", name="formatoConductor__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FormatoConductor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FormatoConductor entity.
     *
     * @Route("/{id}", name="formatoConductor__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoConductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FormatoConductor entity.
     *
     * @Route("/{id}/edit", name="formatoConductor__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoConductor entity.');
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
    * Creates a form to edit a FormatoConductor entity.
    *
    * @param FormatoConductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FormatoConductor $entity)
    {
        $form = $this->createForm(new FormatoConductorType(), $entity, array(
            'action' => $this->generateUrl('formatoConductor__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FormatoConductor entity.
     *
     * @Route("/{id}", name="formatoConductor__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:FormatoConductor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoConductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formatoConductor__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FormatoConductor entity.
     *
     * @Route("/{id}", name="formatoConductor__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoConductor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FormatoConductor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formatoConductor_'));
    }

    /**
     * Creates a form to delete a FormatoConductor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formatoConductor__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
