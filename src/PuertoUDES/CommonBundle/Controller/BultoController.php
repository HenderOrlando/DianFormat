<?php

namespace PuertoUDES\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\CommonBundle\Entity\Bulto;
use PuertoUDES\CommonBundle\Form\BultoType;

/**
 * Bulto controller.
 *
 * @Route("/bulto_")
 */
class BultoController extends Controller
{

    /**
     * Lists all Bulto entities.
     *
     * @Route("/", name="bulto_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESCommonBundle:Bulto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Bulto entity.
     *
     * @Route("/", name="bulto__create")
     * @Method("POST")
     * @Template("PuertoUDESCommonBundle:Bulto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Bulto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bulto__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Bulto entity.
    *
    * @param Bulto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Bulto $entity)
    {
        $form = $this->createForm(new BultoType(), $entity, array(
            'action' => $this->generateUrl('bulto__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Bulto entity.
     *
     * @Route("/new", name="bulto__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bulto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Bulto entity.
     *
     * @Route("/{id}", name="bulto__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Bulto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bulto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Bulto entity.
     *
     * @Route("/{id}/edit", name="bulto__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Bulto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bulto entity.');
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
    * Creates a form to edit a Bulto entity.
    *
    * @param Bulto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bulto $entity)
    {
        $form = $this->createForm(new BultoType(), $entity, array(
            'action' => $this->generateUrl('bulto__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Bulto entity.
     *
     * @Route("/{id}", name="bulto__update")
     * @Method("PUT")
     * @Template("PuertoUDESCommonBundle:Bulto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESCommonBundle:Bulto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bulto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bulto__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Bulto entity.
     *
     * @Route("/{id}", name="bulto__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESCommonBundle:Bulto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bulto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bulto_'));
    }

    /**
     * Creates a form to delete a Bulto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bulto__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
