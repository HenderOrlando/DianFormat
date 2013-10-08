<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GastoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('valorFlete')
            ->add('otrosGastos')
            ->add('fechaCreado')
            ->add('usuario')
            ->add('formato')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\Gasto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_gasto';
    }
}
