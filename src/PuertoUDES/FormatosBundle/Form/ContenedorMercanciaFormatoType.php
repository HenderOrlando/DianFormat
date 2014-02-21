<?php

namespace PuertoUDES\FormatosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContenedorMercanciaFormatoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pesoBruto')
            ->add('pesoNeto')
            ->add('volumen')
            ->add('volumenOtro')
            //->add('fechaCreado')
            //->add('numBultos')
            //->add('formato')
            //->add('mercancia')
//            ->add('contenedor')
            //->add('bulto')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\FormatosBundle\Entity\ContenedorMercanciaFormato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_formatosbundle_contenedormercanciaformato';
    }
}
