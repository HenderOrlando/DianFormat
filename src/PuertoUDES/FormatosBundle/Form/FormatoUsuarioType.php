<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormatoUsuarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaCreado')
            ->add('usuario')
            ->add('formato')
            ->add('rol')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\FormatoUsuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_formatousuario';
    }
}
