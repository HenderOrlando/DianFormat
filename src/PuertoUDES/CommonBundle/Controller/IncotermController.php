<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Incoterm;
use PuertoUDES\CommonBundle\Form\IncotermType;

/**
 * Incoterm controller.
 *
 * @Route("/incoterm_")
 */
class IncotermController extends Controller
{

    /**
     * Lists all Incoterm entities.
     *
     * @Route("/", name="incoterm_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Incoterm entity.
     *
     * @Route("/", name="incoterm__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Incoterm:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Incoterm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('incoterm__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Incoterm entity.
    *
    * @param Incoterm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Incoterm $entity)
    {
        $form = $this->createForm(new IncotermType(), $entity, array(
            'action' => $this->generateUrl('incoterm__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Incoterm entity.
     *
     * @Route("/new", name="incoterm__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Incoterm();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Incoterm entity.
     *
     * @Route("/{id}/edit", name="incoterm__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
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
    * Creates a form to edit a Incoterm entity.
    *
    * @param Incoterm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Incoterm $entity)
    {
        $form = $this->createForm(new IncotermType(), $entity, array(
            'action' => $this->generateUrl('incoterm__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Incoterm:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Incoterm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('incoterm__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Incoterm entity.
     *
     * @Route("/{id}", name="incoterm__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Incoterm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Incoterm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('incoterm_'));
    }

    /**
     * Creates a form to delete a Incoterm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('incoterm__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
