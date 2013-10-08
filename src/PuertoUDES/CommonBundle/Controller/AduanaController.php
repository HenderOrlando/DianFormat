<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Aduana;
use PuertoUDES\CommonBundle\Form\AduanaType;

/**
 * Aduana controller.
 *
 * @Route("/aduana_")
 */
class AduanaController extends Controller
{

    /**
     * Lists all Aduana entities.
     *
     * @Route("/", name="aduana_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Aduana')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Aduana entity.
     *
     * @Route("/", name="aduana__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Aduana:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Aduana();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aduana__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Aduana entity.
    *
    * @param Aduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Aduana $entity)
    {
        $form = $this->createForm(new AduanaType(), $entity, array(
            'action' => $this->generateUrl('aduana__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Aduana entity.
     *
     * @Route("/new", name="aduana__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Aduana();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Aduana entity.
     *
     * @Route("/{id}", name="aduana__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Aduana entity.
     *
     * @Route("/{id}/edit", name="aduana__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
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
    * Creates a form to edit a Aduana entity.
    *
    * @param Aduana $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Aduana $entity)
    {
        $form = $this->createForm(new AduanaType(), $entity, array(
            'action' => $this->generateUrl('aduana__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Aduana entity.
     *
     * @Route("/{id}", name="aduana__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Aduana:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aduana entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aduana__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Aduana entity.
     *
     * @Route("/{id}", name="aduana__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Aduana')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Aduana entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aduana_'));
    }

    /**
     * Creates a form to delete a Aduana entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aduana__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
