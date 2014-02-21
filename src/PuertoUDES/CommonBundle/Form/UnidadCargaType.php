<?php

namespace PuertoUDES\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnidadCargaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marca')
            ->add('anioFabrica')
            ->add('placa')
            ->add('pais')
            ->add('cargas')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\CommonBundle\Entity\UnidadCarga'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_commonbundle_unidadcarga';
    }
}
