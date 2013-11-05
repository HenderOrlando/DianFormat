<?php

namespace PuertoUDES\FosUsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\GroupController as BaseController;

class GroupController extends BaseController
{
    /**
     * Show all groups
     */
    public function listAction()
    {
        $groups = $this->container->get('fos_user.group_manager')->findGroups();

        return $this->container->get('templating')->renderResponse('PuertoUDESFosUsuarioBundle:Group:list.html.'.$this->getEngine(), array('groups' => $groups));
    }

    /**
     * Show one group
     */
    public function showAction($groupName)
    {
        $group = $this->findGroupBy('name', $groupName);

        return $this->container->get('templating')->renderResponse('PuertoUDESFosUsuarioBundle:Group:show.html.'.$this->getEngine(), array('group' => $group));
    }

    /**
     * Edit one group, show the edit form
     */
    public function editAction(Request $request, $groupName)
    {
        $group = $this->findGroupBy('name', $groupName);

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $event = new GetResponseGroupEvent($group, $request);
        $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.group.form.factory');

        $form = $formFactory->createForm();
        $form->setData($group);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
                $groupManager = $this->container->get('fos_user.group_manager');

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_EDIT_SUCCESS, $event);

                $groupManager->updateGroup($group);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_group_show', array('groupName' => $group->getName()));
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_EDIT_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse('PuertoUDESFosUsuarioBundle:Group:edit.html.'.$this->getEngine(), array(
            'form'      => $form->createview(),
            'group_name'  => $group->getName(),
        ));
    }

    /**
     * Show the new form
     */
    public function newAction(Request $request)
    {
        /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
        $groupManager = $this->container->get('fos_user.group_manager');
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.group.form.factory');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $group = $groupManager->createGroup('');

        $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_CREATE_INITIALIZE, new GroupEvent($group, $request));

        $form = $formFactory->createForm();
        $form->setData($group);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_CREATE_SUCCESS, $event);

                $groupManager->updateGroup($group);

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_group_show', array('groupName' => $group->getName()));
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_CREATE_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

                return $response;
            }
        }

        return $this->container->get('templating')->renderResponse('PuertoUDESFosUsuarioBundle:Group:new.html.'.$this->getEngine(), array(
            'form' => $form->createview(),
        ));
    }

    /**
     * Delete one group
     */
    public function deleteAction(Request $request, $groupName)
    {
        $group = $this->findGroupBy('name', $groupName);
        $this->container->get('fos_user.group_manager')->deleteGroup($group);

        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_group_list'));

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch(PuertoUDESFosUsuarioEvents::GROUP_DELETE_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

        return $response;
    }

    /**
     * Find a group by a specific property
     *
     * @param string $key   property name
     * @param mixed  $value property value
     *
     * @throws NotFoundHttpException                if user does not exist
     * @return \FOS\UserBundle\Model\GroupInterface
     */
    protected function findGroupBy($key, $value)
    {
        if (!empty($value)) {
            $group = $this->container->get('fos_user.group_manager')->{'findGroupBy'.ucfirst($key)}($value);
        }

        if (empty($group)) {
            throw new NotFoundHttpException(sprintf('El grupo con "%s" no existe exist para el valor "%s"', $key, $value));
        }

        return $group;
    }

    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
}
