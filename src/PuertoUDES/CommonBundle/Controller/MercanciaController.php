<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Mercancia;
use PuertoUDES\CommonBundle\Form\MercanciaType;

/**
 * Mercancia controller.
 *
 * @Route("/Mercancia/")
 */
class MercanciaController extends Controller
{

    /**
     * Lists all Mercancia entities.
     *
     * @Route("/", name="mercancia_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Mercancia entity.
     *
     * @Route("/", name="mercancia__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Mercancia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mercancia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mercancia__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Mercancia entity.
    *
    * @param Mercancia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Mercancia $entity)
    {
        $form = $this->createForm(new MercanciaType(), $entity, array(
            'action' => $this->generateUrl('mercancia__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mercancia entity.
     *
     * @Route("/new", name="mercancia__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mercancia();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mercancia entity.
     *
     * @Route("/{id}/edit", name="mercancia__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
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
    * Creates a form to edit a Mercancia entity.
    *
    * @param Mercancia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mercancia $entity)
    {
        $form = $this->createForm(new MercanciaType(), $entity, array(
            'action' => $this->generateUrl('mercancia__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Mercancia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mercancia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mercancia__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mercancia entity.
     *
     * @Route("/{id}", name="mercancia__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Mercancia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mercancia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mercancia_'));
    }

    /**
     * Creates a form to delete a Mercancia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mercancia__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
