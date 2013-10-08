<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\UnidadCarga;
use PuertoUDES\CommonBundle\Form\UnidadCargaType;

/**
 * UnidadCarga controller.
 *
 * @Route("/unidadCarga_")
 */
class UnidadCargaController extends Controller
{

    /**
     * Lists all UnidadCarga entities.
     *
     * @Route("/", name="unidadCarga_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new UnidadCarga entity.
     *
     * @Route("/", name="unidadCarga__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:UnidadCarga:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UnidadCarga();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('unidadCarga__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a UnidadCarga entity.
    *
    * @param UnidadCarga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(UnidadCarga $entity)
    {
        $form = $this->createForm(new UnidadCargaType(), $entity, array(
            'action' => $this->generateUrl('unidadCarga__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UnidadCarga entity.
     *
     * @Route("/new", name="unidadCarga__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UnidadCarga();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UnidadCarga entity.
     *
     * @Route("/{id}/edit", name="unidadCarga__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
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
    * Creates a form to edit a UnidadCarga entity.
    *
    * @param UnidadCarga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UnidadCarga $entity)
    {
        $form = $this->createForm(new UnidadCargaType(), $entity, array(
            'action' => $this->generateUrl('unidadCarga__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:UnidadCarga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('unidadCarga__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UnidadCarga entity.
     *
     * @Route("/{id}", name="unidadCarga__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:UnidadCarga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UnidadCarga entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('unidadCarga_'));
    }

    /**
     * Creates a form to delete a UnidadCarga entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unidadCarga__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
