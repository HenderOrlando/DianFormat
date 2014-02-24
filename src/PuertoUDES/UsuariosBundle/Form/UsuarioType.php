<?php

namespace PuertoUDES\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UsuarioType extends AbstractType
{
    private $user;
    private $rol;
    
    public function __construct(\PuertoUDES\FosUsuarioBundle\Entity\FosUser $fu, \PuertoUDES\CommonBundle\Entity\Rol $rol = null) {
        $this->user = $fu;
        $this->rol = $rol;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('direccion')
            ->add('telefono')
            ->add('docId')
//            ->add('grupo')
        ;
        if($this->user->hasRole('ROLE_ADMIN') || $this->user->getUsuario()->hasRol('Docente') && isset($options['data']) && $options['data']->hasRol('Estudiante')){
            $builder
                ->add('grupo');
        }
        if($this->user->hasRole('ROLE_ADMIN') && !is_null($this->rol) && is_object($this->rol)){
            $builder
                ->add('roles', null,array(
                    'class'    =>  'PuertoUDESCommonBundle:Rol',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                            ->andWhere("r.canonical LIKE '%".$this->rol->getCanonical()."%' OR r.nombre LIKE '%".$this->rol->getNombre()."%'")
                            ->andWhere("r.aplicableA LIKE '%Usuario%'");
                    },
                    'data'  => array($this->rol),
                    'label' =>  false,
                    'attr'  =>  array(
                        'class' =>  'hide'
                    ),
                ));
        }elseif($this->user->hasRole('ROLE_ADMIN')){
            $builder
                ->add('roles');
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\UsuariosBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_usuariosbundle_usuario';
    }
}
