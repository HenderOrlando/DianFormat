<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\FormatoUsuario;
use PuertoUDES\FormatosBundle\Form\FormatoUsuarioType;

/**
 * FormatoUsuario controller.
 *
 * @Route("/formatoUsuario_")
 */
class FormatoUsuarioController extends Controller
{

    /**
     * Lists all FormatoUsuario entities.
     *
     * @Route("/", name="formatoUsuario_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FormatoUsuario entity.
     *
     * @Route("/", name="formatoUsuario__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:FormatoUsuario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FormatoUsuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formatoUsuario__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FormatoUsuario entity.
    *
    * @param FormatoUsuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FormatoUsuario $entity)
    {
        $form = $this->createForm(new FormatoUsuarioType(), $entity, array(
            'action' => $this->generateUrl('formatoUsuario__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FormatoUsuario entity.
     *
     * @Route("/new", name="formatoUsuario__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FormatoUsuario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FormatoUsuario entity.
     *
     * @Route("/{id}", name="formatoUsuario__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoUsuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FormatoUsuario entity.
     *
     * @Route("/{id}/edit", name="formatoUsuario__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoUsuario entity.');
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
    * Creates a form to edit a FormatoUsuario entity.
    *
    * @param FormatoUsuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FormatoUsuario $entity)
    {
        $form = $this->createForm(new FormatoUsuarioType(), $entity, array(
            'action' => $this->generateUrl('formatoUsuario__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FormatoUsuario entity.
     *
     * @Route("/{id}", name="formatoUsuario__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:FormatoUsuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FormatoUsuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formatoUsuario__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FormatoUsuario entity.
     *
     * @Route("/{id}", name="formatoUsuario__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:FormatoUsuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FormatoUsuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formatoUsuario_'));
    }

    /**
     * Creates a form to delete a FormatoUsuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formatoUsuario__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
