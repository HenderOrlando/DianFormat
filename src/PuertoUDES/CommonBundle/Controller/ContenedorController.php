<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Contenedor;
use PuertoUDES\CommonBundle\Form\ContenedorType;

/**
 * Contenedor controller.
 *
 * @Route("/contenedor_")
 */
class ContenedorController extends Controller
{

    /**
     * Lists all Contenedor entities.
     *
     * @Route("/", name="contenedor_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Contenedor entity.
     *
     * @Route("/", name="contenedor__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Contenedor:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contenedor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contenedor__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Contenedor entity.
    *
    * @param Contenedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Contenedor $entity)
    {
        $form = $this->createForm(new ContenedorType(), $entity, array(
            'action' => $this->generateUrl('contenedor__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contenedor entity.
     *
     * @Route("/new", name="contenedor__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contenedor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Contenedor entity.
     *
     * @Route("/{id}/edit", name="contenedor__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
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
    * Creates a form to edit a Contenedor entity.
    *
    * @param Contenedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contenedor $entity)
    {
        $form = $this->createForm(new ContenedorType(), $entity, array(
            'action' => $this->generateUrl('contenedor__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Contenedor:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contenedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contenedor__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contenedor entity.
     *
     * @Route("/{id}", name="contenedor__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Contenedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contenedor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contenedor_'));
    }

    /**
     * Creates a form to delete a Contenedor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contenedor__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
