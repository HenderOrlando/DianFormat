<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\UsuariosBundle\Entity\Conductor;
use PuertoUDES\UsuariosBundle\Form\ConductorType;

/**
 * Conductor controller.
 *
 * @Route("/Conductor_")
 */
class ConductorController extends Controller
{

    /**
     * Lists all Conductor entities.
     *
     * @Route("/", name="Conductor_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Conductor entity.
     *
     * @Route("/", name="Conductor__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Conductor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Conductor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('Conductor__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Conductor entity.
    *
    * @param Conductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Conductor $entity)
    {
        $form = $this->createForm(new ConductorType(), $entity, array(
            'action' => $this->generateUrl('Conductor__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Conductor entity.
     *
     * @Route("/new", name="Conductor__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Conductor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Conductor entity.
     *
     * @Route("/{id}", name="Conductor__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Conductor entity.
     *
     * @Route("/{id}/edit", name="Conductor__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
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
    * Creates a form to edit a Conductor entity.
    *
    * @param Conductor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Conductor $entity)
    {
        $form = $this->createForm(new ConductorType(), $entity, array(
            'action' => $this->generateUrl('Conductor__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Conductor entity.
     *
     * @Route("/{id}", name="Conductor__update")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Conductor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conductor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('Conductor__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Conductor entity.
     *
     * @Route("/{id}", name="Conductor__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESUsuariosBundle:Conductor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conductor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Conductor_'));
    }

    /**
     * Creates a form to delete a Conductor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Conductor__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
