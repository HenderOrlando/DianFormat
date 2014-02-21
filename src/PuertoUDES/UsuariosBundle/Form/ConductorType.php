<?php

namespace PuertoUDES\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConductorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('direccion')
            ->add('telefono')
            ->add('docId')
            ->add('numLicencia')
            ->add('numLibretaTripulante')
            ->add('claseLicencia', 'entity', array(
                'class' => 'PuertoUDESCommonBundle:Tipo',
                'property' => 'fullName',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.aplicableA LiKE '%Conductor%'")
                        ->orderBy('t.nombre', 'ASC');
                },
            ))
            ->add('pais')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PuertoUDES\UsuariosBundle\Entity\Conductor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'puertoudes_usuariosbundle_conductor';
    }
}
