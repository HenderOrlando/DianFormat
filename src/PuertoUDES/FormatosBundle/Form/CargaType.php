<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CargaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('numPrecintos')
            ->add('naturalezaCarga')
            ->add('formato')
            ->add('lugar')
            ->add('unidadCargas')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\Carga'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_carga';
    }
}
