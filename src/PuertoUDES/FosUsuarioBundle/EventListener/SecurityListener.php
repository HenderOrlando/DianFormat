<?php

namespace PuertoUDES\FosUsuarioBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityListener
{
    protected $security;
    protected $session;

/**
* Constructs a new instance of SecurityListener.
*
* @param SecurityContext $security The security context
* @param Session $session The session
*/
    public function __construct(SecurityContext $security, Session $session)
    {
        //You can bring whatever you need here, but for a start this should be useful to you
        $this->security = $security;
        $this->session = $session;
    }

/**
* Invoked after a successful login.
*
* @param InteractiveLoginEvent $event The event
*/
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
         $security = $this->security; 
         $fosuser = $security->getToken()->getUser();
         $usuario = $fosuser->getUsuario();
         if ($usuario) {
             foreach($usuario->getRoles() as $rol ){
                $fosuser->addRole('ROLE_'.$this->normaliza($rol->getNombre()));
             }
         }
    }
    
    public function normaliza ($cadena, $mayus = true){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        if(is_bool($mayus) && $mayus)
            $cadena = strtoupper($cadena);
        else
            $cadena = strtolower($cadena);
        return str_replace(' ', '-', utf8_encode($cadena));
    }
}