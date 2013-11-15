<?php

namespace PuertoUDES\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntidadType extends AbstractType
{
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
            ->add('certificadoIdoneidad')
            ->add('permisosPresentaServicios')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\UsuariosBundle\Entity\Entidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_usuariosbundle_entidad';
    }
}
