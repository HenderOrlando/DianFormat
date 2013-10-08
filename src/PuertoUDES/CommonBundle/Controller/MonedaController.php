<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Moneda;
use PuertoUDES\CommonBundle\Form\MonedaType;

/**
 * Moneda controller.
 *
 * @Route("/moneda_")
 */
class MonedaController extends Controller
{

    /**
     * Lists all Moneda entities.
     *
     * @Route("/", name="moneda_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Moneda')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Moneda entity.
     *
     * @Route("/", name="moneda__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Moneda:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Moneda();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moneda__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Moneda entity.
    *
    * @param Moneda $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Moneda $entity)
    {
        $form = $this->createForm(new MonedaType(), $entity, array(
            'action' => $this->generateUrl('moneda__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Moneda entity.
     *
     * @Route("/new", name="moneda__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Moneda();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Moneda entity.
     *
     * @Route("/{id}", name="moneda__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Moneda entity.
     *
     * @Route("/{id}/edit", name="moneda__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
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
    * Creates a form to edit a Moneda entity.
    *
    * @param Moneda $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Moneda $entity)
    {
        $form = $this->createForm(new MonedaType(), $entity, array(
            'action' => $this->generateUrl('moneda__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Moneda entity.
     *
     * @Route("/{id}", name="moneda__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Moneda:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Moneda entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moneda__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Moneda entity.
     *
     * @Route("/{id}", name="moneda__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Moneda')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Moneda entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moneda_'));
    }

    /**
     * Creates a form to delete a Moneda entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moneda__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
