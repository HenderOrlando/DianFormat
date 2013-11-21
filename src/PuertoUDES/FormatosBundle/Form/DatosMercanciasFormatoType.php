<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatosMercanciasFormatoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaCreado')
            ->add('formato')
            ->add('lugar')
            ->add('tipo')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\DatosMercanciasFormato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_datosmercanciasformato';
    }
}
