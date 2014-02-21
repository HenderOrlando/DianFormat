<?php

namespace PuertoUDES\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    private $user;
    
    public function __construct(\PuertoUDES\FosUsuarioBundle\Entity\FosUser $fu) {
        $this->user = $fu;
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
        if($this->user->hasRole('ROLE_ADMIN')){
            $builder
                ->add('grupo');
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
