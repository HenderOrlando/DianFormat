<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\Gasto;
use PuertoUDES\FormatosBundle\Form\GastoType;

/**
 * Gasto controller.
 *
 * @Route("/gasto_")
 */
class GastoController extends Controller
{

    /**
     * Lists all Gasto entities.
     *
     * @Route("/", name="gasto_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Gasto entity.
     *
     * @Route("/", name="gasto__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Gasto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Gasto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gasto__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Gasto entity.
    *
    * @param Gasto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Gasto $entity)
    {
        $form = $this->createForm(new GastoType(), $entity, array(
            'action' => $this->generateUrl('gasto__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Gasto entity.
     *
     * @Route("/new", name="gasto__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Gasto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Gasto entity.
     *
     * @Route("/{id}", name="gasto__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Gasto entity.
     *
     * @Route("/{id}/edit", name="gasto__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
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
    * Creates a form to edit a Gasto entity.
    *
    * @param Gasto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Gasto $entity)
    {
        $form = $this->createForm(new GastoType(), $entity, array(
            'action' => $this->generateUrl('gasto__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Gasto entity.
     *
     * @Route("/{id}", name="gasto__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Gasto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gasto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gasto__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Gasto entity.
     *
     * @Route("/{id}", name="gasto__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Gasto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gasto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gasto_'));
    }

    /**
     * Creates a form to delete a Gasto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gasto__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
