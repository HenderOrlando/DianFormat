<?php

namespace PuertoUDES\FormatosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PuertoUDES\FormatosBundle\Entity\Carga;
use PuertoUDES\FormatosBundle\Form\CargaType;

/**
 * Carga controller.
 *
 * @Route("/Carga/")
 */
class CargaController extends Controller
{

    /**
     * Lists all Carga entities.
     *
     * @Route("/", name="carga_")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PuertoUDESFormatosBundle:Carga')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Carga entity.
     *
     * @Route("/", name="carga__create")
     * @Method("POST")
     * @Template("PuertoUDESFormatosBundle:Carga:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Carga();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('carga__show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Carga entity.
    *
    * @param Carga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Carga $entity)
    {
        $form = $this->createForm(new CargaType(), $entity, array(
            'action' => $this->generateUrl('carga__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Carga entity.
     *
     * @Route("/new", name="carga__new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Carga();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Carga entity.
     *
     * @Route("/{id}", name="carga__show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Carga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Carga entity.
     *
     * @Route("/{id}/edit", name="carga__edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Carga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carga entity.');
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
    * Creates a form to edit a Carga entity.
    *
    * @param Carga $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carga $entity)
    {
        $form = $this->createForm(new CargaType(), $entity, array(
            'action' => $this->generateUrl('carga__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Carga entity.
     *
     * @Route("/{id}", name="carga__update")
     * @Method("PUT")
     * @Template("PuertoUDESFormatosBundle:Carga:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PuertoUDESFormatosBundle:Carga')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carga entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('carga__edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Carga entity.
     *
     * @Route("/{id}", name="carga__delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PuertoUDESFormatosBundle:Carga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Carga entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('carga_'));
    }

    /**
     * Creates a form to delete a Carga entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carga__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
