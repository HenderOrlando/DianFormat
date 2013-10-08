<?php

namespace PuertoUDES\UsuariosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\UsuariosBundle\Entity\Entidad;
use PuertoUDES\UsuariosBundle\Form\EntidadType;

/**
 * Entidad controller.
 *
 * @Route("/entidad_")
 */
class EntidadController extends Controller
{

    /**
     * Lists all Entidad entities.
     *
     * @Route("/", name="entidad_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Entidad entity.
     *
     * @Route("/", name="entidad__create")
     * @Method("POST")
     * @Template("PuertoUDESUsuariosBundle:Entidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Entidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entidad entity.
     *
     * @Route("/new", name="entidad__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Entidad();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Entidad entity.
     *
     * @Route("/{id}", name="entidad__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Entidad entity.
     *
     * @Route("/{id}/edit", name="entidad__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
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
    * Creates a form to edit a Entidad entity.
    *
    * @param Entidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entidad $entity)
    {
        $form = $this->createForm(new EntidadType(), $entity, array(
            'action' => $this->generateUrl('entidad__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entidad entity.
     *
     * @Route("/{id}", name="entidad__update")
     * @Method("PUT")
     * @Template("PuertoUDESUsuariosBundle:Entidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entidad__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Entidad entity.
     *
     * @Route("/{id}", name="entidad__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESUsuariosBundle:Entidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entidad_'));
    }

    /**
     * Creates a form to delete a Entidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entidad__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
