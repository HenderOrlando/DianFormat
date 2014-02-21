<?php

namespace PuertoUDES\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TipoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('abreviacion')
            ->add('descripcion')
            ->add('aplicableA','choice',array(
                'choices'   =>  array(
                    'Aduana'    => 'Aduana',
                    'Carga'     => 'Carga',
                    'Conductor' => 'Conductor',
                    'Formato'   => 'Formato',
                    'Usuario'   => 'Usuario',
                    'datosMercancias'   => 'Datos de Mercancía',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\CommonBundle\Entity\Tipo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_commonbundle_tipo';
    }
}
