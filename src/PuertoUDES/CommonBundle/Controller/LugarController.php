<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Lugar;
use PuertoUDES\CommonBundle\Form\LugarType;

/**
 * Lugar controller.
 *
 * @Route("/lugar_")
 */
class LugarController extends Controller
{

    /**
     * Lists all Lugar entities.
     *
     * @Route("/", name="lugar_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Lugar')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Lugar entity.
     *
     * @Route("/", name="lugar__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Lugar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lugar();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lugar__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Lugar entity.
    *
    * @param Lugar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Lugar $entity)
    {
        $form = $this->createForm(new LugarType(), $entity, array(
            'action' => $this->generateUrl('lugar__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lugar entity.
     *
     * @Route("/new", name="lugar__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lugar();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lugar entity.
     *
     * @Route("/{id}", name="lugar__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lugar entity.
     *
     * @Route("/{id}/edit", name="lugar__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
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
    * Creates a form to edit a Lugar entity.
    *
    * @param Lugar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lugar $entity)
    {
        $form = $this->createForm(new LugarType(), $entity, array(
            'action' => $this->generateUrl('lugar__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Lugar entity.
     *
     * @Route("/{id}", name="lugar__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Lugar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lugar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lugar__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lugar entity.
     *
     * @Route("/{id}", name="lugar__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Lugar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lugar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lugar_'));
    }

    /**
     * Creates a form to delete a Lugar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lugar__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
