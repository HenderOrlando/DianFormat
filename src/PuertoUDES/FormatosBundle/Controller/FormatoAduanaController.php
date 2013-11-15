<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\FormatoAduana;
use PuertoUDES\FormatosBundle\Form\FormatoAduanaType;

/**
 * FormatoAduana controller.
 *
 * @Route("/FormatoAduana/")
 */
class FormatoAduanaController extends Controller
{

    /**
     * Lists all FormatoAduana entities.
     *
     * @Route("/", name="formatoAduana_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:FormatoAduana')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FormatoAduana entity.
     *
     * @Route("/", name="formatoAduana__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:FormatoAduana:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FormatoAduana();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formatoAduana__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FormatoAduana entity.
    *
    * @param FormatoAduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FormatoAduana $entity)
    {
        $form = $this->createForm(new FormatoAduanaType(), $entity, array(
            'action' => $this->generateUrl('formatoAduana__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FormatoAduana entity.
     *
     * @Route("/new", name="formatoAduana__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FormatoAduana();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FormatoAduana entity.
     *
     * @Route("/{id}", name="formatoAduana__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoAduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoAduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FormatoAduana entity.
     *
     * @Route("/{id}/edit", name="formatoAduana__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoAduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoAduana entity.');
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
    * Creates a form to edit a FormatoAduana entity.
    *
    * @param FormatoAduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FormatoAduana $entity)
    {
        $form = $this->createForm(new FormatoAduanaType(), $entity, array(
            'action' => $this->generateUrl('formatoAduana__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FormatoAduana entity.
     *
     * @Route("/{id}", name="formatoAduana__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:FormatoAduana:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoAduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoAduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formatoAduana__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FormatoAduana entity.
     *
     * @Route("/{id}", name="formatoAduana__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoAduana')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FormatoAduana entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formatoAduana_'));
    }

    /**
     * Creates a form to delete a FormatoAduana entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formatoAduana__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
